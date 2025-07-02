<?php

namespace Modules\Backend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\Users\Models\FormBarangPakaiHabisModel;
use Modules\Users\Models\FormHasilPeriksaModel;
use Modules\Users\Models\FormKartuKendaliModel;
use Modules\Users\Models\FormKonsumsiModel;
use Modules\Users\Models\FormPeliharaModel;

class BackendController extends Controller
{
    protected $theme;

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
        $data_v['konsumsi'] = FormKonsumsiModel::limit(5)->orderBy('id','DESC')->get();
        $data_v['pemeliharaan'] = FormPeliharaModel::limit(5)->orderBy('id','DESC')->get();
        $data_v['barang_pakai_habis'] = FormBarangPakaiHabisModel::limit(5)->orderBy('id','DESC')->get();
        // if(auth()->user()->hasRole('administrator')){
            $data_v['hasil'] = DB::select("select h.id,h.name,h.file_attach,h.users_id,h.users_receiver, u.name as fullname, h.created_at, h.status_approval, h.approved_by, h.approved_at, h.approval_notes, h.parent_id, h.is_reply, h.reply_level, (select count(*) from form_hasil_periksa r where r.parent_id = h.id) as reply_count from form_hasil_periksa h left join users u on u.id=h.users_id where h.is_reply = 0 order by h.created_at desc limit 5");
        // }else{
        //     $data_v['hasil'] = DB::select("select h.id,h.name,h.file_attach,h.users_id,h.users_receiver, u.name as fullname, h.created_at, h.status_approval, h.approved_by, h.approved_at, h.approval_notes, h.parent_id, h.is_reply, h.reply_level, (select count(*) from form_hasil_periksa r where r.parent_id = h.id) as reply_count from form_hasil_periksa h left join users u on u.id=h.users_id where (h.users_id = :user_id or h.users_receiver= :receiver) and h.is_reply = 0 order by h.created_at desc limit 25",['user_id'=>\Auth::user()->id,'receiver'=>\Auth::user()->id]);
        // }
        $data_v['kartu_kendali'] = FormKartuKendaliModel::limit(5)->orderBy('id','DESC')->get();
        return view('backend::'.$this->theme.'.index')->with($data_v);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('backend::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('backend::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
