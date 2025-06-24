<?php

namespace Modules\HasilPeriksa\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Modules\HasilPeriksa\Models\FormHasilPeriksaModel;
use Modules\Users\Models\JenisKonsumsiModel;
use Modules\Users\Models\SubBagModel;
use Modules\Users\Models\UsersModel;

class HasilPeriksaController extends Controller
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
        return view('hasilperiksa::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_v['title'] = 'Hasil Pemeriksaan Awal Tim';
        $data_v['title_sub'] = 'Hasil Pemeriksaan Awal Tim';
        array_push($this->breadcrumb, ['title' => 'Sistem Eksternal', 'url' => '#' , 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Tambah', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $jenis_konsumsi = JenisKonsumsiModel::all();
        $data_v['jenis_konsumsi'] = $jenis_konsumsi;
        $sub_bag = SubBagModel::all();
        $data_v['sub_bag'] = $sub_bag;
        if(auth()->user()->hasRole('administrator')){
            $data_v['users']=UsersModel::where('id','<>',\Auth::user()->id)->get();
            // $data_v['hasil']=FormHasilPeriksaModel::limit(25)->orderBy('created_at','DESC')->get();
        }else{
            // $data_v['hasil']=FormHasilPeriksaModel::where('users_id',\Auth::user()->id)->orWhere('users_receiver',\Auth::user()->id)->limit(25)->orderBy('created_at','DESC')->get();
            $data_v['hasil']=DB::select("select h.id,h.name,h.file_attach,h.users_id,h.users_receiver, u.name as fullname, h.created_at from form_hasil_periksa h left join users u on u.id=h.users_id where h.users_id = :user_id or h.users_receiver= :receiver order by h.created_at limit 25",['user_id'=>\Auth::user()->id,'receiver'=>\Auth::user()->id]);
        }

        return view('hasilperiksa::'.$this->theme.'.create')->with($data_v);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'name' => [
                'required' => 'Nama dokumen tidak boleh kosong',
            ],
        ];

        if(auth()->user()->hasRole('administrator')){
            $messages = [
                'receiver' => [
                    'required' => 'Penerima tidak boleh kosong',
                ],
            ];
            $validator = Validator::make($request->all(), [
                'receiver' => ['required', 'string', 'max:255'],
            ], $messages);
        }

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],

        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.hasil.create')->withErrors($validator)->withInput();
        }

        $receiver=0;
        if($request->receiver){
            $receiver=$request->receiver;
        }

        $fileattach = $request->file('file_attach');
        $filename = null;
        if ($fileattach) {
            $filename = uniqid() . time() . '.' . $fileattach->getClientOriginalExtension();
            //Storage::disk('uploads')->put('filename', $filename);
            $store = Storage::putFileAs('hasil', $fileattach,$filename);
        }

        $save = FormHasilPeriksaModel::create([
            'name' => $request->name,
            'file_attach' => $filename,
            'users_id' => \Auth::user()->id,
            'users_receiver' => $receiver
            //'created_by' => \Auth::user()->id
        ]);
        if ($save) {
            \App\Helpers\NumesaHelper::log('INFO', 'Menambahkan Data Hasil Pemeriksaan Tim :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil disimpan');
            return Redirect::route('form.hasil.create')->with('status', 'created');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('hasilperiksa::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id=decrypt($id);
        $data_v['title'] = 'Edit Hasil Pemeriksaan Awal Tim';
        $data_v['title_sub'] = 'Edit Hasil Pemeriksaan Awal Tim';
        array_push($this->breadcrumb, ['title' => 'Sistem Eksternal', 'url' => '#' , 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Hasil Pemeriksaan Awal', 'url' => '#' , 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Edit', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['hasil']=FormHasilPeriksaModel::where(['id'=>$id,'users_id'=>\Auth::user()->id])->first();
        if(auth()->user()->hasRole('administrator')){
            $data_v['users']=UsersModel::where('id','<>',\Auth::user()->id)->get();
        }

        return view('hasilperiksa::'.$this->theme.'.edit')->with($data_v);
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
            'name' => ['required', 'string', 'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.hasil.update',['id' => encrypt($id)])->withErrors($validator)->withInput();
        }

        $receiver = 0;
        if($request->input('receiver')){
            $receiver=$request->receiver;
        }

        $fileattach = $request->file('file_attach');
        $filename=null;
        if ($fileattach) {
            $filename = uniqid() . time() . '.' . $fileattach->getClientOriginalExtension();
            //Storage::disk('uploads')->put('filename', $filename);
            $store = Storage::putFileAs('hasil', $fileattach,$filename);
            $save = FormHasilPeriksaModel::find($id)->update([
                'name'=>$request->name,
                'file_attach'=>$filename,
                'users_id' => \Auth::user()->id,
                'users_receiver' => $receiver
            ]);

            if($save){
                \App\Helpers\NumesaHelper::log('INFO', 'Melakukan Perubahan Data Hasil Pemeriksaan Tim :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil melakukan perubahan');
                return Redirect::route('form.hasil.update',['id'=>encrypt($id)])->with('status', 'created');
            }
        }else{
            $save = FormHasilPeriksaModel::find($id)->update([
                'name'=>$request->name,
                'users_id' => \Auth::user()->id,
                'users_receiver' => $receiver
            ]);

            if($save){
                \App\Helpers\NumesaHelper::log('INFO', 'Melakukan Perubahan Data Hasil Pemeriksaan Tim :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil melakukan perubahan');
                return Redirect::route('form.hasil.update',['id'=>encrypt($id)])->with('status', 'created');
            }
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
        $row = FormHasilPeriksaModel::where(['id'=>$pid,'users_id'=>\Auth::user()->id])->first();
        if ($row) {
            $name = $row->name;
            if (file_exists(public_path('hasil'.'/'.$row->file_attach))) {
                Storage::delete('hasil'.'/'.$row->file_attach);
                $delete = FormHasilPeriksaModel::where(['id'=> $pid,'users_id'=>\Auth::user()->id])->delete();
                if (!$delete) {
                    return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Data ' . $name . ' Gagal dihapus']);
                }else{
                    \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Data Hasil Pemeriksaan :' . $name, \Auth::user()->id);
                    return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
                }
            }else{
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'File lama ' . $name . ' Tidak ditemukan, tidak dapat melanjutkan penghapusan']);
            }


        }
    }

    public function getFilesUser(Request $request){
        if (!$request->ajax()) {
            return response('Request Tidak Benar', 400);
        }
        $users_id = $request->pid;
        $hasil_periksa = DB::select("select h.id,h.name,h.file_attach,h.users_id,h.users_receiver, u.name as fullname, h.created_at from form_hasil_periksa h left join users u on u.id=h.users_id where h.users_id = :user_id or (h.users_id = :admin_id and h.users_receiver= :receiver) order by h.created_at limit 25",['user_id'=>$users_id,'receiver'=>$users_id,'admin_id'=>\Auth::user()->id]);
        $collection = collect($hasil_periksa)->map(function($value){
            $value->id = encrypt($value->id);
            $value->url=route('form.hasil.edit',['id'=>$value->id]);
            return $value;
        });

        // $hasil_periksa = FormHasilPeriksaModel::where('users_id',$users_id)->orWhere('users_id',\Auth::user()->id)->limit(25)->orderBy('created_at','DESC')->get();

        return response()->json(['success'=>true,'current_id'=>auth()->user()->id,'result'=>$collection],200);

    }
}
