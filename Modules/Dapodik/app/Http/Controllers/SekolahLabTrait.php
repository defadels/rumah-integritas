<?php

namespace Modules\Dapodik\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Modules\Dapodik\Imports\ImportKepalaSekolahClass;
use Modules\Dapodik\Imports\ImportSekolahAdmClass;
use Modules\Dapodik\Imports\ImportSekolahClass;
use Modules\Dapodik\Imports\ImportSekolahLabClass;
use Modules\Dapodik\Imports\ImportSekolahRombelClass;
use Modules\Dapodik\Imports\ImportSekolahRuangKelasClass;
use Modules\Dapodik\Imports\ImportSekolahSiswaRekapClass;
use Modules\Dapodik\Models\DapodikKepalaSekolahModel;
use Modules\Dapodik\Models\DapodikSekolahAdministrasiModel;
use Modules\Dapodik\Models\DapodikSekolahLabModel;
use Modules\Dapodik\Models\DapodikSekolahModel;
use Modules\Dapodik\Models\DapodikSekolahRombelModel;
use Modules\Dapodik\Models\DapodikSekolahRuangKelasModel;
use Modules\Dapodik\Models\DapodikSekolahSiswaModel;
use Modules\Users\Models\RoleHasPermissionsModel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Modules\Users\Models\RolesModel;
use Modules\Users\Models\UsersModel;
use Maatwebsite\Excel\Facades\Excel;

trait SekolahLabTrait
{
    public function indexSekolahLab(Request $request)
    {
        $data_v['title'] = 'Sekolah - Laboratorium';
        $data_v['title_sub'] = 'Sekolah - Laboratorium';
        array_push($this->breadcrumb, ['title' => 'Sekolah','url' => '/'.config('app.backend') . '/dapodik/sekolah','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Laboratorium','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['append_src'] = array('s' => $request->get('s'));
        $data_v['s'] = $request->has('s') ? $request['s'] : null;
        $data_v['listdata'] = DapodikSekolahLabModel::Filter($request)->paginate(20);
        $data_v['kondisi_label'] = collect(['Baik','Rusak Ringan','Rusak Sedang','Rusak Berat','Rusak Total']);
        $data_v['kondisis'] = collect(['baik','rusak_ringan','rusak_sedang','rusak_berat','rusak_total']);
        return view('dapodik::'.$this->theme.'.sekolah-lab.index')->with($data_v);
    }

    public function importSekolahLab(Request $request)
    {
        $data_v['title'] = 'Sekolah - Laboratorium - Import';
        $data_v['title_sub'] = 'Sekolah - Laboratorium - Import';
        array_push($this->breadcrumb, ['title' => 'Sekolah','url' => '/'.config('app.backend') . '/dapodik/sekolah','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Laboratorium','url' => '/'.config('app.backend') . '/dapodik/sekolah-lab','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Import','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        return view('dapodik::'.$this->theme.'.sekolah-lab.import')->with($data_v);
    }

    public function storeSekolahLab(Request $request)
    {
        $messages = [
            /*'name.unique' => 'Role sudah ada.',*/
        ];
        $validator = Validator::make($request->all(),[
            'file_attach' => [ File::types('xls,xlsx')->max(12*1024)]
        ],$messages);
        if($validator->fails()){
            return Redirect::route('dapodik.sekolah-lab.import')->withErrors($validator)->withInput();
        }
        $file = $request->file('file_attach');
        /*kosongkan data*/
        DapodikSekolahLabModel::truncate();
        $import = new ImportSekolahLabClass;
        $save = Excel::import($import,$file);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Import Data Sekolah Laboratorium : ' . $file->getClientOriginalName(), \Auth::user()->id);
            \Session::flash('messages', $import->getRowCount().' data berhasil diimport');
            return Redirect::route('dapodik.sekolah-lab.import')->with('status', 'sekolah-lab-imported');
        }else{
            \Session::flash('messages', 'Data gagal diimport');
            return Redirect::route('dapodik.sekolah-lab.import')->with('status', 'sekolah-lab-failed');
        }
    }

    public function destroySekolahLab(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(['validasi' => $validator->errors(), 'pesan' => 'cek request anda'], 400);
        }
        if (!$request->ajax()) {
            return response('Request Tidak Benar', 400);
        }
        $pid = $request->get('pid');
        $row = DapodikSekolahLabModel::where('id', '=', $pid)->first();
        if ($row) {
            $name = $row->nama_sekolah;
            $check = $this->checkExistSekolahLab($pid);
            if ($check) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Data ' . $name . ' masih terkait dengan data lainnya']);
            } else {
                $delete = DapodikSekolahLabModel::where('id', '=', $pid)->delete();
                if ($delete) {
                    \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Sekolah Lab :' . $name, \Auth::user()->id);
                    return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
                }
            }

        }
    }

    public function destroySekolahLabAll(Request $request)
    {
        if (!$request->ajax()) {
            return response('Request Tidak Benar', 400);
        }
        $validator = Validator::make($request->all(), [
            'ids' => 'required',
        ]);
        if ($validator->fails()) {
            return response('Request Tidak Benar : ' . $validator->errors(), 405);
        }
        $array_pid = $request->get('ids');
        $i = 0;
        $array_pid_sukses = array();
        foreach ($array_pid as $pid) {
            $row = DapodikSekolahLabModel::where('id', '=', $pid)->first();
            if ($row) {
                $name = $row->nama_sekolah;
                $check = $this->checkExistSekolahLab($pid);
                if ($check) {

                } else {
                    $delete = DapodikSekolahLabModel::where('id', '=', $pid)->delete();
                    if ($delete) {
                        $i++;
                        array_push($array_pid_sukses, array('pid' => $pid, 'name' => $name));
                    }
                }
            }
        }
        if($i > 0) {
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete ' . $i . ' Sekolah Lab', \Auth::user()->id);
            return response()->json(['status' => 'success', 'array_pid_sukses' => $array_pid_sukses, 'judul' => 'Sukses!', 'pesan' => $i . ' data berhasil dihapus']);
        }else{
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Gagal Delete ', \Auth::user()->id);
            return response()->json(['status' => 'error', 'judul' => 'Gagal!', 'pesan' => 'Data gagal dihapus']);
        }
    }

    public function checkExistSekolahLab($id)
    {
        $exist = FALSE;
        /*if(RoleHasPermissionsModel::where('role_id','=',$role_id)->exists()){
            $exist = TRUE;
        }*/
        return $exist;
    }

}
