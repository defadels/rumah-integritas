<?php

namespace Modules\Dapodik\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Modules\Dapodik\Imports\ImportGuruClass;
use Modules\Dapodik\Imports\ImportKepalaSekolahClass;
use Modules\Dapodik\Models\DapodikGuruModel;
use Modules\Dapodik\Models\DapodikKepalaSekolahModel;
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

trait GuruTrait
{
    public function indexGuru(Request $request)
    {
        $data_v['title'] = 'Guru';
        $data_v['title_sub'] = 'Guru';
        array_push($this->breadcrumb, ['title' => 'Kepala Sekolah','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['append_src'] = array('s' => $request->get('s'));
        $data_v['s'] = $request->has('s') ? $request['s'] : null;
        $data_v['listdata'] = DapodikGuruModel::Filter($request)->paginate(20);
        return view('dapodik::'.$this->theme.'.guru.index')->with($data_v);
    }

    public function importGuru(Request $request)
    {
        $data_v['title'] = 'Guru';
        $data_v['title_sub'] = 'Guru';
        array_push($this->breadcrumb, ['title' => 'Guru','url' => '/'.config('app.backend') . '/dapodik/guru','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Import','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['kec'] = NULL;
        return view('dapodik::'.$this->theme.'.guru.import')->with($data_v);
    }

    public function storeGuru(Request $request)
    {
        $messages = [
            /*'name.unique' => 'Role sudah ada.',*/
        ];
        $validator = Validator::make($request->all(),[
            'file_attach' => [ File::types('csv')->max(12*1024)],
            'kec' => 'required'
        ],$messages);
        if($validator->fails()){
            return Redirect::route('dapodik.guru.import')->withErrors($validator)->withInput();
        }
        $file = $request->file('file_attach');
        $kec = $request->kec;
        /*kosongkan data*/
        DapodikGuruModel::where('kecamatan_id','=',$kec)->delete();
        $import = new ImportGuruClass($kec);
        $save = Excel::import($import,$file);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Import Data Guru : ' . $file->getClientOriginalName(), \Auth::user()->id);
            \Session::flash('messages', $import->getRowCount().' data berhasil diimport');
            return Redirect::route('dapodik.guru.import')->with('status', 'guru-imported');
        }else{
            \Session::flash('messages', 'Data gagal diimport');
            return Redirect::route('dapodik.guru.import')->with('status', 'guru-failed');
        }
    }

    public function destroyGuru(Request $request)
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
        $row = DapodikGuruModel::where('id', '=', $pid)->first();
        if ($row) {
            $name = $row->nama_lengkap;
            $check = $this->checkExistGuru($pid);
            if ($check) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Data ' . $name . ' masih terkait dengan data lainnya']);
            } else {
                $delete = DapodikGuruModel::where('id', '=', $pid)->delete();
                if ($delete) {
                    \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Guru :' . $name, \Auth::user()->id);
                    return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
                }
            }

        }
    }

    public function destroyGuruAll(Request $request)
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
            $row = DapodikGuruModel::where('id', '=', $pid)->first();
            if ($row) {
                $name = $row->nama_lengkap;
                $check = $this->checkExistGuru($pid);
                if ($check) {

                } else {
                    $delete = DapodikGuruModel::where('id', '=', $pid)->delete();
                    if ($delete) {
                        $i++;
                        array_push($array_pid_sukses, array('pid' => $pid, 'name' => $name));
                    }
                }
            }
        }
        if($i > 0) {
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete ' . $i . ' Guru', \Auth::user()->id);
            return response()->json(['status' => 'success', 'array_pid_sukses' => $array_pid_sukses, 'judul' => 'Sukses!', 'pesan' => $i . ' data berhasil dihapus']);
        }else{
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Gagal Delete ', \Auth::user()->id);
            return response()->json(['status' => 'error', 'judul' => 'Gagal!', 'pesan' => 'Data gagal dihapus']);
        }
    }

    public function checkExistGuru($id)
    {
        $exist = FALSE;
        /*if(RoleHasPermissionsModel::where('role_id','=',$role_id)->exists()){
            $exist = TRUE;
        }*/
        return $exist;
    }

}
