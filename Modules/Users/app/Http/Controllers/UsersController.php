<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Modules\Users\Models\LogsModel;
use Modules\Users\Models\UsersProfileModel;
use Validator;
use Modules\Users\Models\UsersModel;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    use RolesTrait;
    use ProfileTrait;

    protected $theme;

    public function __construct()
    {
        $this->theme = config('app.backend_theme');
        $this->breadcrumb = [];
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data_v['title'] = 'Users';
        $data_v['title_sub'] = 'Users';
        array_push($this->breadcrumb, ['title' => 'Daftar User', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['append_src'] = array('aktif' => $request->get('aktif'), 's' => $request->get('s'));
        $data_v['s'] = $request->has('s') ? $request['s'] : null;
        $data_v['aktif'] = $request->has('aktif') ? $request['aktif'] : null;
        $data_v['listdata'] = UsersModel::Filter($request)->paginate(20);
        return view('users::' . $this->theme . '.index')->with($data_v);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data_v['title'] = 'Tambah User';
        $data_v['title_sub'] = 'Tambah User';
        array_push($this->breadcrumb, ['title' => 'Users', 'url' => '/' . config('app.backend') . '/users', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Tambah', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $role = Role::all();
        $data_v['role'] = $role;
        return view('users::' . $this->theme . '.create')->with($data_v);
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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'password' => ['required', 'confirmed'],
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('users.create')->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_active' => $request->isactive,
            'created_by' => \Auth::user()->id
        ]);
        $user->syncRoles($request->checkbox_role);
        if ($user) {
            $user_id = $user->id;
            $user_profile = UsersProfileModel::create([
                'user_id' => $user_id,
                'created_by' => \Auth::user()->id
            ]);
            \App\Helpers\NumesaHelper::log('INFO', 'Menambahkan Data User :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Menambahkan User ' . $request->name);
            return Redirect::route('users.create')->with('status', 'user-created');
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $data_v['title'] = 'Edit User';
        $data_v['title_sub'] = 'Edit User';
        array_push($this->breadcrumb, ['title' => 'Users', 'url' => '/' . config('app.backend') . '/users', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Edit', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['id'] = $user->id;
        $data_v['name'] = $user->name;
        $data_v['email'] = $user->email;
        $data_v['isactive'] = $user->is_active;
        $data_v['isactive_checked'] = $user->is_active == 1 ? 'checked' : '';

        $checked_role = $user->getRoleNames()->toArray();
        $role = Role::all();
        $arr_role = [];
        foreach ($role as $row) {
            $checked = in_array($row->name,$checked_role) ? 'checked' : '';
            $arr_role[] = ['id' => $row->id,'name' => $row->name, 'checked' => $checked];
        }
        $data_v['role'] = collect($arr_role);
        return view('users::' . $this->theme . '.update')->with($data_v);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $messages = [
           /* 'email.unique' => 'Email sudah ada.',*/
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('users.update',['id' => $id])->withErrors($validator)->withInput();
        }

        $save = User::find($id)->update(['name' => $request->name, 'is_active' => $request->isactive, 'updated_by' => \Auth::user()->id]);
        if($save){
            $user->syncRoles($request->checkbox_role);
            \App\Helpers\NumesaHelper::log('INFO', 'Update User :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Merubah User ' . $request->name);
            return Redirect::route('users.update',['id' => $id])->with('status', 'user-updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
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
        $row = User::where('id', '=', $pid)->first();
        if ($row) {
            $name = $row->name;
            $check = $this->checkExist($pid);
            if ($check) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Role ' . $name . ' masih terkait dengan data lainnya']);
            } else {
                $delete = User::where('id', '=', $pid)->delete();
                if ($delete) {
                    $delete_profile = UsersProfileModel::where('user_id', '=', $pid)->delete();
                    \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete User :' . $name, \Auth::user()->id);
                    return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
                }
            }

        }
    }

    public function destroyAll(Request $request)
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
            $row = User::where('id', '=', $pid)->first();
            if ($row) {
                $name = $row->name;
                $check = $this->checkExist($pid);
                if ($check) {

                } else {
                    $delete = User::where('id', '=', $pid)->delete();
                    if ($delete) {
                        $delete_profile = UsersProfileModel::where('user_id', '=', $pid)->delete();
                        $i++;
                        array_push($array_pid_sukses, array('pid' => $pid, 'name' => $name));
                    }
                }
            }
        }
        if($i > 0) {
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete ' . $i . ' User', \Auth::user()->id);
            return response()->json(['status' => 'success', 'array_pid_sukses' => $array_pid_sukses, 'judul' => 'Sukses!', 'pesan' => $i . ' data berhasil dihapus']);
        }else{
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Gagal Delete ', \Auth::user()->id);
            return response()->json(['status' => 'error', 'judul' => 'Gagal!', 'pesan' => 'Data gagal dihapus']);
        }
    }

    public function checkExist($user_id)
    {
        $exist = FALSE;
        /*if(RoleHasPermissionsModel::where('role_id','=',$role_id)->exists()){
            $exist = TRUE;
        }*/
        return $exist;
    }

    public function editPassword($id)
    {
        $user = User::findOrFail($id);
        $data_v['title'] = 'Ganti Password';
        $data_v['title_sub'] = 'Ganti Password';
        array_push($this->breadcrumb, ['title' => 'Users', 'url' => '/' . config('app.backend') . '/users', 'active' => false]);
        array_push($this->breadcrumb, ['title' => 'Password', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['id'] = $user->id;
        $data_v['name'] = $user->name;
        return view('users::' . $this->theme . '.password')->with($data_v);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updatePassword(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $messages = [
            /* 'email.unique' => 'Email sudah ada.',*/
        ];
        $validator = Validator::make($request->all(), [
             'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('users.password',['id' => $id])->withErrors($validator)->withInput();
        }

        $save = User::find($id)->update(['password' => Hash::make($request->password),'updated_by' => \Auth::user()->id]);
        if($save){
            $user->syncRoles($request->checkbox_role);
            \App\Helpers\NumesaHelper::log('INFO', 'Update Password :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Merubah Password User ' . $request->name);
            return Redirect::route('users.password',['id' => $id])->with('status', 'user-password-updated');
        }
    }

    public function indexLogs(Request $request)
    {
        $data_v['title'] = 'Logs';
        $data_v['title_sub'] = 'Logs';
        array_push($this->breadcrumb, ['title' => 'Logs', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['append_src'] = array('aktif' => $request->get('aktif'), 's' => $request->get('s'));
        $data_v['s'] = $request->has('s') ? $request['s'] : null;
        $data_v['listdata'] = LogsModel::Filter($request)->orderBy('id','DESC')->paginate(20);
        return view('users::' . $this->theme . '.logs')->with($data_v);
    }
}
