<?php

namespace Modules\PengajuanKonsumsi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Modules\PengajuanKonsumsi\Models\FormKonsumsiModel;
use Modules\Users\Models\JenisKonsumsiModel;
use Modules\Users\Models\JenisKonsumsiRelModel;
use Modules\Users\Models\SubBagModel;
use Modules\Users\Models\SubBagRelModel;

class PengajuanKonsumsiController extends Controller
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
        return view('pengajuankonsumsi::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_v['title'] = 'Form Permohonan Makan Minum';
        $data_v['title_sub'] = 'Form Permohonan Makan Minum';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '/' . config('app.backend') . '/users', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Tambah', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $jenis_konsumsi = JenisKonsumsiModel::all();
        $data_v['jenis_konsumsi'] = $jenis_konsumsi;
        $sub_bag = SubBagModel::all();
        $data_v['sub_bag'] = $sub_bag;

        return view('pengajuankonsumsi::'.$this->theme.'.create')->with($data_v);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $messages = [
            'email' => [
                'required' => 'Email tidak boleh kosong',
                'email' => 'Masukkan Email yang valid',
            ],
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.makan.create')->withErrors($validator)->withInput();
        }

        $save = FormKonsumsiModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'judul_rapat' => $request->judul_rapat,
            'waktu' => $request->waktu,
            'jml_konsumsi' => $request->jml_konsumsi,
            'setuju' => $request->setuju
            //'created_by' => \Auth::user()->id
        ]);
        if ($save) {
            $arr_jenis = $request->checkbox_jenis_konsumsi;
            foreach ($arr_jenis as $k => $v){
                $save_jenis = JenisKonsumsiRelModel::create([
                    'form_konsumsi_id' => $save->id,
                    'jenis_id' => $v
                ]);
            }
            $arr_sub_bag = $request->checkbox_sub_bag;
            foreach ($arr_sub_bag as $k => $v){
                $save_jenis = SubBagRelModel::create([
                    'form_konsumsi_id' => $save->id,
                    'sub_bag_id' => $v
                ]);
            }
            \App\Helpers\NumesaHelper::log('INFO', 'Menambahkan Data Pengajuan Makan Minum :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil disimpan');
            return Redirect::route('form.makan.create')->with('status', 'created');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('pengajuankonsumsi::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id=decrypt($id);
        $data_v['title'] = 'Form Edit Permohonan Makan Minum';
        $data_v['title_sub'] = 'Form Edit Permohonan Makan Minum';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Pengajuan Makan Minum', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Edit', 'url' => '#', 'active' => true]);
        $konsumsi = DB::select("
        select f.id,f.name,f.email,f.judul_rapat,f.waktu,f.jml_konsumsi, jr.jenis_id, sr.sub_bag_id from form_konsumsi f left join jenis_konsumsi_rel jr on f.id=jr.form_konsumsi_id left join jenis_konsumsi j on j.id=jr.jenis_id left join sub_bag_rel sr on sr.form_konsumsi_id = f.id left join sub_bag s on s.id=sr.sub_bag_id where f.id = :id
        ",['id'=>$id]);

        $data_v['jenis_konsumsi']=JenisKonsumsiModel::all();
        $data_v['konsumsi']=$konsumsi;
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['sub_bag'] = SubBagModel::all();

        return view('pengajuankonsumsi::'.$this->theme.'.edit')->with($data_v);
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
            return Redirect::route('form.makan.edit',['id' => encrypt($id)])->withErrors($validator)->withInput();
        }

        $save = FormKonsumsiModel::find($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'judul_rapat' => $request->judul_rapat,
            'waktu' => $request->waktu,
            'jml_konsumsi' => $request->jml_konsumsi,
            'setuju' => $request->setuju
        ]);
        if($save){
            $arr_jenis = $request->checkbox_jenis_konsumsi;
            foreach ($arr_jenis as $k => $v){
                $save_jenis = JenisKonsumsiRelModel::where('form_konsumsi_id',$id)->update([
                    'jenis_id' => $v
                ]);
            }
            $arr_sub_bag = $request->checkbox_sub_bag;
            foreach ($arr_sub_bag as $k => $v){
                $save_jenis = SubBagRelModel::where('form_konsumsi_id',$id)->update([
                    'sub_bag_id' => $v
                ]);
            }

            \App\Helpers\NumesaHelper::log('INFO', 'Perubahan Data Pengajuan Makan Minum :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Melakukan Perubahan');
            return Redirect::route('form.makan.edit',['id' => encrypt($id)])->with('status', 'updated');
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
        $row = FormKonsumsiModel::where('id', $pid)->first();
        // $row = User::where('id', '=', $pid)->first();
        if ($row) {
            $name = $row->name;
            // $check = $this->checkExist($pid);
            $check_relasi_jenis_konsumsi = JenisKonsumsiRelModel::where('form_konsumsi_id',$pid)->delete();
            $check_relasi_sub_bag = SubBagRelModel::where('form_konsumsi_id',$pid)->delete();
            if (!$check_relasi_jenis_konsumsi && !$check_relasi_sub_bag) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Something went wrong!']);
            } else {
                $delete = FormKonsumsiModel::where('id', $pid)->delete();
                if ($delete) {
                    \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Data Konsumsi :' . $name, \Auth::user()->id);
                    return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
                }
            }

        }
    }
}
