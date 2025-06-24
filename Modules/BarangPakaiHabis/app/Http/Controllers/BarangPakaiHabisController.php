<?php

namespace Modules\BarangPakaiHabis\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Modules\BarangPakaiHabis\Models\FormBarangPakaiHabisModel;

class BarangPakaiHabisController extends Controller
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
        return view('barangpakaihabis::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_v['title'] = 'Form Agenda Inspektorat / Pengajuan Agenda Inspektorat';
        $data_v['title_sub'] = 'Form Agenda Inspektorat / Pengajuan Agenda Inspektorat';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Tambah', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        // dd($data_v['breadcrumb']);
        // $jenis_konsumsi = JenisKonsumsiModel::all();
        // $data_v['jenis_konsumsi'] = $jenis_konsumsi;
        // $sub_bag = SubBagModel::all();
        // $data_v['sub_bag'] = $sub_bag;
        return view('barangpakaihabis::'.$this->theme.'.create')->with($data_v);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'email' => [
                'required' => 'Email tidak boleh kosong',
                'email' => 'Masukkan Alamat Email yang valid'
            ],
            'namakegiatan' => [
                'required'=>'Nama kegiatan tidak boleh kosong'
            ]
        ];
        $validator = Validator::make($request->all(), [
            'namakegiatan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ], $messages);

        if ($validator->fails()) {
            return Redirect::route('form.barang.pakai.habis.create')->withErrors($validator)->withInput();
        }

        $post=$request->input();

        // hilangkan _token
        $tmppost = $post;
        foreach ($tmppost as $key => $value) {
            if ($key === "_token") {
                unset($post[$key]);
            }
        }

        $save = FormBarangPakaiHabisModel::create($post);
        if ($save) {
            \App\Helpers\NumesaHelper::log('INFO', 'Menambahkan Data Pengajuan Barang Pakai Habis :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil disimpan');
            return Redirect::route('form.barang.pakai.habis.create')->with('status', 'created');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('barangpakaihabis::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id = decrypt($id);
        $data_v['title'] = 'Form Edit Pengajuan Barang Pakai Habis';
        $data_v['title_sub'] = 'Form Edit Pengajuan Barang Pakai Habis';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Barang Pakai Habis', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Edit', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        // $jenis_konsumsi = JenisKonsumsiModel::all();
        // $data_v['jenis_konsumsi'] = $jenis_konsumsi;
        // $sub_bag = SubBagModel::all();
        // $data_v['sub_bag'] = $sub_bag;
        $data_v['barang']=FormBarangPakaiHabisModel::where('id',$id)->first();
        return view('barangpakaihabis::'.$this->theme.'.edit')->with($data_v);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $id = decrypt($id);
        $messages = [
           /* 'email.unique' => 'Email sudah ada.',*/
        ];
        $validator = Validator::make($request->all(), [
            'namakegiatan' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.barang.pakai.habis.edit',['id' => encrypt($id)])->withErrors($validator)->withInput();
        }

        $post=$request->input();

        // hilangkan _token
        $tmppost = $post;
        foreach ($tmppost as $key => $value) {
            if ($key === "_token") {
                unset($post[$key]);
            }
        }

        $save = FormBarangPakaiHabisModel::find($id)->update($post);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Melakukan Perubahan Data Pengajuan Barang Pakai Habis :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil melakukan perubahan');
            return Redirect::route('form.barang.pakai.habis.edit',['id'=>encrypt($id)])->with('status', 'updated');
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
        $row = FormBarangPakaiHabisModel::where('id', $pid)->first();
        if ($row) {
            $name = $row->name;
            $delete = FormBarangPakaiHabisModel::where('id', $pid)->delete();
            if ($delete) {
                \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Data Barang Habis Pakai :' . $name, \Auth::user()->id);
                return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
            }else{
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Gagal menghapus data!']);
            }
        }else{
            return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Something went wrong!']);
        }
    }
}
