<?php

namespace Modules\HasilPeriksa\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApprovalTrait;
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
use Str;

class HasilPeriksaController extends Controller
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
        return FormHasilPeriksaModel::class;
    }

    /**
     * Implementation for ApprovalTrait
     */
    protected function getSubmissionName($submission)
    {
        return $submission->name;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data_v['title'] = 'Hasil Pemeriksaan Awal Tim';
        $data_v['title_sub'] = 'Daftar Hasil Pemeriksaan Awal Tim';
        array_push($this->breadcrumb, ['title' => 'Sistem Eksternal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Hasil Pemeriksaan Awal Tim', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;

        // Get documents with reply functionality
        if(auth()->user()->hasRole('administrator')){
            // Administrator can see all documents
            $data_v['hasil'] = DB::select("
                select h.id,h.name,h.file_attach,h.users_id,h.users_receiver, 
                       u.name as fullname, ur.name as receiver_name, h.created_at, 
                       h.status_approval, h.approved_by, h.approved_at, h.approval_notes, 
                       h.parent_id, h.is_reply, h.reply_level, h.reply_message,
                       (select count(*) from form_hasil_periksa r where r.parent_id = h.id) as reply_count 
                from form_hasil_periksa h 
                left join users u on u.id=h.users_id 
                left join users ur on ur.id=h.users_receiver 
                where h.is_reply = 0 
                order by h.created_at desc limit 50
            ");
        } else {
            // Regular users can only see documents they are involved in
            $data_v['hasil'] = DB::select("
                select h.id,h.name,h.file_attach,h.users_id,h.users_receiver, 
                       u.name as fullname, ur.name as receiver_name, h.created_at, 
                       h.status_approval, h.approved_by, h.approved_at, h.approval_notes, 
                       h.parent_id, h.is_reply, h.reply_level, h.reply_message,
                       (select count(*) from form_hasil_periksa r where r.parent_id = h.id) as reply_count 
                from form_hasil_periksa h 
                left join users u on u.id=h.users_id 
                left join users ur on ur.id=h.users_receiver 
                where (h.users_id = :user_id or h.users_receiver = :receiver) 
                and h.is_reply = 0 
                order by h.created_at desc limit 50
            ", ['user_id' => auth()->user()->id, 'receiver' => auth()->user()->id]);
        }

        return view('hasilperiksa::'.$this->theme.'.index')->with($data_v);
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

        // $fileattach = $request->file('file_attach');
        // $filename = null;
        // if ($fileattach) {
        //     $filename = uniqid() . time() . '.' . $fileattach->getClientOriginalExtension();

        //     //Storage::disk('uploads')->put('filename', $filename);
        //     $store = Storage::putFileAs('hasil', $fileattach,$filename);
        // }

        $save = FormHasilPeriksaModel::create([
            'name' => $request->name,
            'users_id' => \Auth::user()->id,
            'users_receiver' => $receiver
            //'created_by' => \Auth::user()->id
        ]);

        if($request->hasFile('file_attach')){
             $filename = Str::uuid();
             $path = 'hasil/';
             $file_extension = $request->file_attach->extension();
             $save->file_attach = $path.$filename.".".$file_extension;

             $dokumen = $request->file('file_attach');
             $destinationPath = storage_path('app/public/'. $path);

             $dokumen->move($destinationPath, $filename . '.' . $file_extension);

             $file_url = Storage::url($save->file_attach);

             $save->save();

        }

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
        if(auth()->user()->hasRole('administrator') || auth()->user()->hasRole('OPD')){
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
            // $filename = uniqid() . time() . '.' . $fileattach->getClientOriginalExtension();
            //Storage::disk('uploads')->put('filename', $filename);
            // $store = Storage::putFileAs('hasil', $fileattach,$filename);

            $save = FormHasilPeriksaModel::find($id);

            $save->name = $request->name;
            $save->users_id = \Auth::user()->id;
            $save->users_receiver = $receiver;

            if($request->hasFile('file_attach')){

                $dokumen_lama = $save->file_attach;

                $filename = Str::uuid();
                $path = 'hasil/';
                $file_extension = $request->file_attach->extension();
                $save->file_attach = $path.$filename.".".$file_extension;

                $dokumen = $request->file('file_attach');
                $destinationPath = storage_path('app/public/'. $path);

                $dokumen->move($destinationPath, $filename . '.' . $file_extension);

                $file_url = Storage::url($save->file_attach);

                $save->save();

                if($dokumen_lama != null){
                    Storage::disk('public')->delete($dokumen_lama);
                }

            }

            $save->save();

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
            if (Storage::url($row->file_attach) != null) {
                Storage::disk('public')->delete($row->file_attach);
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

    /**
     * Show form to reply to a document
     */
    public function reply($id)
    {
        $id = decrypt($id);
        $parent = FormHasilPeriksaModel::with(['sender', 'receiver'])->findOrFail($id);
        
        // Check if user has permission to reply
        if (!auth()->user()->hasRole('administrator') && 
            !auth()->user()->hasRole('OPD') &&
            $parent->users_id != auth()->user()->id && 
            $parent->users_receiver != auth()->user()->id) {
            abort(403, 'Anda tidak memiliki akses untuk membalas dokumen ini');
        }

        $data_v['title'] = 'Balas Dokumen - ' . $parent->name;
        $data_v['title_sub'] = 'Balas Dokumen';
        array_push($this->breadcrumb, ['title' => 'Sistem Eksternal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Hasil Pemeriksaan Awal', 'url' => route('form.hasil.index'), 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Balas', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['parent'] = $parent;

        return view('hasilperiksa::'.$this->theme.'.reply')->with($data_v);
    }

    /**
     * Store reply to a document
     */
    public function storeReply(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'parent_id' => 'required|exists:form_hasil_periksa,id',
            'name' => 'required|string|max:255',
            'reply_message' => 'required|string',
        ], [
            'name.required' => 'Nama dokumen balasan tidak boleh kosong',
            'reply_message.required' => 'Pesan balasan tidak boleh kosong',
            'parent_id.required' => 'ID dokumen induk tidak valid',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $parent = FormHasilPeriksaModel::findOrFail($request->parent_id);
        
        // Check permission
        if (!auth()->user()->hasRole('administrator') && 
            $parent->users_id != auth()->user()->id && 
            $parent->users_receiver != auth()->user()->id) {
            abort(403, 'Anda tidak memiliki akses untuk membalas dokumen ini');
        }

        // Determine receiver (if current user is sender, receiver becomes the original receiver, and vice versa)
        $receiver = ($parent->users_id == auth()->user()->id) ? $parent->users_receiver : $parent->users_id;

        $replyData = [
            'name' => $request->name,
            'reply_message' => $request->reply_message,
            'parent_id' => $request->parent_id,
            'is_reply' => true,
            'reply_level' => $parent->reply_level + 1,
            'users_id' => auth()->user()->id,
            'users_receiver' => $receiver,
            'status_approval' => 'pending',
        ];

        $reply = FormHasilPeriksaModel::create($replyData);

        // Handle file upload if exists
        if ($request->hasFile('file_attach')) {
            $filename = Str::uuid();
            $path = 'hasil/replies/';
            $file_extension = $request->file_attach->extension();
            $reply->file_attach = $path . $filename . "." . $file_extension;

            $dokumen = $request->file('file_attach');
            $destinationPath = storage_path('app/public/' . $path);

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $dokumen->move($destinationPath, $filename . '.' . $file_extension);
            $reply->save();
        }

        if ($reply) {
            \App\Helpers\NumesaHelper::log('INFO', 'Membalas dokumen: ' . $parent->name . ' dengan balasan: ' . $request->name, auth()->user()->id);
            \Session::flash('messages', 'Balasan berhasil dikirim');
            return redirect()->route('form.hasil.conversation', ['id' => encrypt($request->parent_id)]);
        }

        return back()->withErrors(['error' => 'Gagal mengirim balasan'])->withInput();
    }

    /**
     * Show conversation (main document with all replies)
     */
    public function conversation($id)
    {
        $id = decrypt($id);
        $document = FormHasilPeriksaModel::with([
            'sender', 
            'receiver', 
            'replies.sender', 
            'replies.receiver'
        ])->findOrFail($id);

        // If this is a reply, get the parent document
        if ($document->is_reply) {
            $document = $document->parent()->with([
                'sender', 
                'receiver', 
                'replies.sender', 
                'replies.receiver'
            ])->first();
        }

        // Check permission
        if (!auth()->user()->hasRole('administrator') && 
            !auth()->user()->hasRole('OPD') &&
            $document->users_id != auth()->user()->id && 
            $document->users_receiver != auth()->user()->id) {
            
            // Check if user is involved in any of the replies
            $hasAccessToReplies = $document->replies->contains(function ($reply) {
                return $reply->users_id == auth()->user()->id || $reply->users_receiver == auth()->user()->id;
            });
            
            if (!$hasAccessToReplies) {
                abort(403, 'Anda tidak memiliki akses untuk melihat percakapan ini');
            }
        }

        $data_v['title'] = 'Percakapan - ' . $document->name;
        $data_v['title_sub'] = 'Percakapan Dokumen';
        array_push($this->breadcrumb, ['title' => 'Sistem Eksternal', 'url' => '#', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Hasil Pemeriksaan Awal', 'url' => route('form.hasil.index'), 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Percakapan', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['document'] = $document;

        return view('hasilperiksa::'.$this->theme.'.conversation')->with($data_v);
    }
}
