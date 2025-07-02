<?php

namespace Modules\KartuKendali\Http\Controllers;

use App\Helpers\NumesaHelper;
use App\Http\Controllers\Controller;
use DateTime;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Modules\KartuKendali\Models\FormKartuKendaliModel;
use App\Traits\ApprovalTrait;

class KartuKendaliController extends Controller
{
    use ApprovalTrait;
    
    protected $theme;
    protected $breadcrumb;

    public function __construct()
    {
        $this->theme = config('app.backend_theme');
        $this->breadcrumb = [];
    }

    /**
     * Implementation for ApprovalTrait
     */
    protected function getModelClass()
    {
        return FormKartuKendaliModel::class;
    }

    /**
     * Implementation for ApprovalTrait
     */
    protected function getSubmissionName($submission)
    {
        return $submission->pekerjaan;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kartukendali::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_v['title'] = 'Form Kartu Kendali';
        $data_v['title_sub'] = 'Form Kartu Kendali';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '/' . config('app.backend') . '/users', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Tambah', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        // $jenis_konsumsi = JenisKonsumsiModel::all();
        // $data_v['jenis_konsumsi'] = $jenis_konsumsi;
        // $sub_bag = SubBagModel::all();
        // $data_v['sub_bag'] = $sub_bag;

        return view('kartukendali::'.$this->theme.'.create')->with($data_v);
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
            'kode_sub' => ['required', 'string', 'max:255'],
            'sub_kegiatan' => ['required', 'string',  'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.kartu.kendali.create')->withErrors($validator)->withInput();
        }

        $pagu_dana = NumesaHelper::nomorInteger($request->pagu_dana);
        $spp_nilai = NumesaHelper::nomorInteger($request->spp_nilai);
        $sisa_anggaran = NumesaHelper::nomorInteger($request->sisa_anggaran);

        $bap_tgl = !empty($request['bap_tgl']) ? DateTime::createFromFormat('d/m/Y', ($request['bap_tgl'])) : null;
        $bast_tgl = !empty($request['bast_tgl']) ? DateTime::createFromFormat('d/m/Y', ($request['bast_tgl'])) : null;
        $bapem_tgl = !empty($request['bast_tgl']) ? DateTime::createFromFormat('d/m/Y', ($request['bast_tgl'])) : null;

        $save = FormKartuKendaliModel::create([
            'kode_sub' => $request->kode_sub,
            'sub_kegiatan' => $request->sub_kegiatan,
            'sub_bidang' => $request->sub_bidang,
            'pekerjaan' => $request->pekerjaan,
            'rekanan' => $request->rekanan,
            'pagu_dana' => $pagu_dana,
            'spk_no' => $request->spk_no,
            'bap_tgl' => $bap_tgl,
            'bap_no' => $request->bap_no,
            'bast_tgl' => $bast_tgl,
            'bast_no' => $request->bast_no,
            'bapem_tgl' => $bapem_tgl,
            'bapem_no' => $request->bapem_no,
            'spp_no' => $request->spp_no,
            'spp_nilai' => $spp_nilai,
            'sisa_anggaran' => $sisa_anggaran,
            'keterangan' => $request->keterangan
            //'created_by' => \Auth::user()->id
        ]);
        if ($save) {
            \App\Helpers\NumesaHelper::log('INFO', 'Menambahkan Data Kendali', \Auth::user()->id);
            \Session::flash('messages', 'Berhasil disimpan');
            return Redirect::route('form.kartu.kendali.create')->with('status', 'created');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('kartukendali::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $id=decrypt($id);
        $data_v['title'] = 'Form Edit Kartu Kendali';
        $data_v['title_sub'] = 'Form Edit Kartu Kendali';
        array_push($this->breadcrumb, ['title' => 'Sistem Internal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Kartu Kendali', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Edit', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['kartu']=FormKartuKendaliModel::where('id',$id)->first();

        return view('kartukendali::'.$this->theme.'.edit')->with($data_v);
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
            'kode_sub' => ['required', 'string', 'max:255'],
            'sub_kegiatan' => ['required', 'string',  'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('form.kartu.kendali.edit',['id' => encrypt($id)])->withErrors($validator)->withInput();
        }

        $pagu_dana = NumesaHelper::nomorInteger($request->pagu_dana);
        $spp_nilai = NumesaHelper::nomorInteger($request->spp_nilai);
        $sisa_anggaran = NumesaHelper::nomorInteger($request->sisa_anggaran);

        $bap_tgl = !empty($request['bap_tgl']) ? DateTime::createFromFormat('d/m/Y', ($request['bap_tgl'])) : null;
        $bast_tgl = !empty($request['bast_tgl']) ? DateTime::createFromFormat('d/m/Y', ($request['bast_tgl'])) : null;
        $bapem_tgl = !empty($request['bast_tgl']) ? DateTime::createFromFormat('d/m/Y', ($request['bast_tgl'])) : null;

        $save = FormKartuKendaliModel::find($id)->update([
            'kode_sub' => $request->kode_sub,
            'sub_kegiatan' => $request->sub_kegiatan,
            'sub_bidang' => $request->sub_bidang,
            'pekerjaan' => $request->pekerjaan,
            'rekanan' => $request->rekanan,
            'pagu_dana' => $pagu_dana,
            'spk_no' => $request->spk_no,
            'bap_tgl' => $bap_tgl,
            'bap_no' => $request->bap_no,
            'bast_tgl' => $bast_tgl,
            'bast_no' => $request->bast_no,
            'bapem_tgl' => $bapem_tgl,
            'bapem_no' => $request->bapem_no,
            'spp_no' => $request->spp_no,
            'spp_nilai' => $spp_nilai,
            'sisa_anggaran' => $sisa_anggaran,
            'keterangan' => $request->keterangan
        ]);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Update Data Kartu kendali :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Melakukan Perubahan');
            return Redirect::route('form.kartu.kendali.edit',['id' => encrypt($id)])->with('status', 'updated');
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
        $row = FormKartuKendaliModel::where('id', $pid)->first();
        if ($row) {
            $name = $row->name;
            $delete = FormKartuKendaliModel::where('id', $pid)->delete();
            if (!$delete) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Gagal Menghapus Data ' . $name]);
            } else {
                \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Data Kartu Kendali :' . $name, \Auth::user()->id);
                return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
            }

        }
    }
}
