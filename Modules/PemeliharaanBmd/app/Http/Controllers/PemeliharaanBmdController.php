<?php

namespace Modules\PemeliharaanBmd\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Modules\PemeliharaanBmd\Models\FormPeliharaModel;
use Modules\Users\Models\JenisPemeliharaanModel;

class PemeliharaanBmdController extends Controller
{
    protected $theme;
    protected $breadcrumb;

    public function __construct()
    {
        $this->theme = config('app.backend_theme');
        $this->breadcrumb = [];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pemeliharaanbmd::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_v['title'] = 'Form Permohonan Fasilitasi Pemeliharaan';
        $data_v['title_sub'] = 'Form Permohonan Fasilitasi Pemeliharaan';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '/' . config('app.backend') . '/users', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Tambah', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $role = JenisPemeliharaanModel::all();
        $data_v['role'] = $role;

        return view('pemeliharaanbmd::'.$this->theme.'.create')->with($data_v);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'email.unique' => 'Email sudah ada.',
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.pelihara.create')->withErrors($validator)->withInput();
        }

        $save = FormPeliharaModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'jenis_pelihara' => $request->jenis_pelihara,
            'jenis_keluhan' => $request->jenis_keluhan,
            'sub_bag' => $request->sub_bag,
            'setuju' => $request->setuju
            //'created_by' => \Auth::user()->id
        ]);
        if ($save) {
            \App\Helpers\NumesaHelper::log('INFO', 'Menambahkan Data User :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil disimpan');
            return Redirect::route('form.pelihara.create')->with('status', 'created');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pemeliharaanbmd::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $data_v['title'] = 'Form Permohonan Fasilitasi Pemeliharaan';
        $data_v['title_sub'] = 'Form Permohonan Fasilitasi Pemeliharaan';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Pemeliharaan', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Edit', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $role = JenisPemeliharaanModel::all();
        $data_v['role'] = $role;
        $data_v['pemeliharaan']=FormPeliharaModel::where('id',$id)->first();

        return view('pemeliharaanbmd::'.$this->theme.'edit')->with($data_v);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $id=decrypt($id);

        $messages = [
           /* 'email.unique' => 'Email sudah ada.',*/
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.pelihara.edit',['id' => encrypt($id)])->withErrors($validator)->withInput();
        }

        $save = FormPeliharaModel::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'jenis_pelihara' => $request->jenis_pelihara,
            'jenis_keluhan' => $request->jenis_keluhan,
            'sub_bag' => $request->sub_bag,
            'setuju' => $request->setuju
        ]);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Melakukan perubahan Data Pemeliharaan :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil melakukan perubahan');
            return Redirect::route('form.pelihara.edit',['id'=>encrypt($id)])->with('status', 'updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pid' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['validasi' => $validator->errors(), 'pesan' => 'cek request anda'], 400);
        }
        if (!$request->ajax()) {
            return response('Request Tidak Benar', 400);
        }
        $pid = decrypt($request->pid);
        $row = FormPeliharaModel::where('id', $pid)->first();
        if ($row) {
            $name = $row->name;
            $delete = FormPeliharaModel::where('id',$pid)->delete();
            if (!$delete) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Gagal Menghapus Data ' . $name]);
            } else {
                \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Data Pemeliharaan :' . $name, \Auth::user()->id);
                return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
            }

        }
    }
}
