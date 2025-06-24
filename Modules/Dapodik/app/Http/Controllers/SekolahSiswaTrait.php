<?php

namespace Modules\Dapodik\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Modules\Dapodik\Imports\ImportKepalaSekolahClass;
use Modules\Dapodik\Imports\ImportSekolahClass;
use Modules\Dapodik\Imports\ImportSekolahSiswaClass;
use Modules\Dapodik\Models\DapodikKepalaSekolahModel;
use Modules\Dapodik\Models\DapodikSekolahModel;
use Modules\Dapodik\Models\DapodikSiswaModel;
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

trait SekolahSiswaTrait
{
    public function indexSekolahSiswa(Request $request, $npsn)
    {
        $row = DapodikSekolahModel::where('npsn','=',$npsn)->firstOrFail();
        $data_v['title'] = $row->nama_sekolah.' - Peserta Didik';
        $data_v['title_sub'] = $row->nama_sekolah.' - Peserta Didik';
        array_push($this->breadcrumb, ['title' => 'Sekolah','url' => '/'.config('app.backend') . '/dapodik/sekolah','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Peserta Didik','url' => '','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['append_src'] = array('s' => $request->get('s'));
        $data_v['s'] = $request->has('s') ? $request['s'] : null;
        $data_v['npsn'] = $npsn;
        $data_v['listdata'] = DapodikSiswaModel::Filter($request)->where('npsn','=',$npsn)->paginate(20);
        return view('dapodik::'.$this->theme.'.sekolah.siswa.index')->with($data_v);
    }

    public function importSekolahSiswa(Request $request, $npsn)
    {
        $row = DapodikSekolahModel::where('npsn','=',$npsn)->firstOrFail();
        $data_v['title'] = $row->nama_sekolah.' - Peserta Didik - Import';
        $data_v['title_sub'] = $row->nama_sekolah.' - Peserta Didik - Import';
        array_push($this->breadcrumb, ['title' => 'Sekolah','url' => '/'.config('app.backend') . '/dapodik/sekolah','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Peserta Didik','url' => '/'.config('app.backend') . '/dapodik/sekolah/'.$npsn.'/siswa','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Import','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['npsn'] = $npsn;
        return view('dapodik::'.$this->theme.'.sekolah.siswa.import')->with($data_v);
    }

    public function storeSekolahSiswa(Request $request, $npsn)
    {
        $row = DapodikSekolahModel::where('npsn','=',$npsn)->firstOrFail();

        $messages = [
            /*'name.unique' => 'Role sudah ada.',*/
        ];
        $validator = Validator::make($request->all(),[
            'file_attach' => [ File::types('xls,xlsx')->max(12*1024)]
        ],$messages);
        if($validator->fails()){
            return Redirect::route('dapodik.sekolah.siswa.import',['npsn' => $npsn])->withErrors($validator)->withInput();
        }
        $file = $request->file('file_attach');
        /*kosongkan data*/
        DapodikSiswaModel::where('npsn','=',$npsn)->delete();
        $import = new ImportSekolahSiswaClass($npsn);
        $save = Excel::import($import,$file);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Import Data Peserta Didik : ' . $row->nama_sekolah, \Auth::user()->id);
            \Session::flash('messages', $import->getRowCount().' data berhasil diimport');
            return Redirect::route('dapodik.sekolah.siswa.import',['npsn' => $npsn])->with('status', 'siswa-imported');
        }else{
            \Session::flash('messages', 'Data gagal diimport');
            return Redirect::route('dapodik.sekolah.siswa.import',['npsn' => $npsn])->with('status', 'siswa-failed');
        }
    }

    public function destroySekolahSiswa(Request $request)
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
        $row = DapodikSiswaModel::where('id', '=', $pid)->first();
        if ($row) {
            $name = $row->nama_lengkap;
            $check = $this->checkExistSekolahSiswa($pid);
            if ($check) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Data ' . $name . ' masih terkait dengan data lainnya']);
            } else {
                $delete = DapodikSiswaModel::where('id', '=', $pid)->delete();
                if ($delete) {
                    \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Peserta Didik :' . $name, \Auth::user()->id);
                    return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
                }
            }

        }
    }

    public function destroySekolahSiswaAll(Request $request)
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
            $row = DapodikSiswaModel::where('id', '=', $pid)->first();
            if ($row) {
                $name = $row->nama_lengkap;
                $check = $this->checkExistSekolahSiswa($pid);
                if ($check) {

                } else {
                    $delete = DapodikSiswaModel::where('id', '=', $pid)->delete();
                    if ($delete) {
                        $i++;
                        array_push($array_pid_sukses, array('pid' => $pid, 'name' => $name));
                    }
                }
            }
        }
        if($i > 0) {
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete ' . $i . ' Peserta Didik', \Auth::user()->id);
            return response()->json(['status' => 'success', 'array_pid_sukses' => $array_pid_sukses, 'judul' => 'Sukses!', 'pesan' => $i . ' data berhasil dihapus']);
        }else{
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Gagal Delete ', \Auth::user()->id);
            return response()->json(['status' => 'error', 'judul' => 'Gagal!', 'pesan' => 'Data gagal dihapus']);
        }
    }

    public function checkExistSekolahSiswa($id)
    {
        $exist = FALSE;
        /*if(RoleHasPermissionsModel::where('role_id','=',$role_id)->exists()){
            $exist = TRUE;
        }*/
        return $exist;
    }

}
