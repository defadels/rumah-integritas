<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
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

trait RolesTrait
{
    public function indexRole(Request $request)
    {
        $data_v['title'] = 'Group Role User';
        $data_v['title_sub'] = 'Group Role User';
        array_push($this->breadcrumb, ['title' => 'Users','url' => '/'.config('app.backend') . '/users','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Group/Role User','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['append_src'] = array('s' => $request->get('s'));
        $data_v['s'] = $request->has('s') ? $request['s'] : null;
        $data_v['listdata'] = RolesModel::Filter($request)->paginate(20);
        return view('users::'.$this->theme.'.roles.index')->with($data_v);
    }

    public function createRole(Request $request)
    {
        $data_v['title'] = 'Tambah Role';
        $data_v['title_sub'] = 'Tambah Role';
        array_push($this->breadcrumb, ['title' => 'Users','url' => '/'.config('app.backend') . '/users','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Group/Role User','url' => '/'.config('app.backend') . '/users/roles','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Tambah','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        return view('users::'.$this->theme.'.roles.create')->with($data_v);
    }

    public function storeRole(Request $request)
    {
        $messages = [
            'name.unique' => 'Role sudah ada.',
        ];
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255', 'unique:roles,name']
        ],$messages);
        if($validator->fails()){
            return Redirect::route('users.roles.create')->withErrors($validator)->withInput();
        }

        $save = RolesModel::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'created_by' => \Auth::user()->id
        ]);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Menambahkan Data Role :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Menambahkan Role ' . $request->name);
            return Redirect::route('users.roles.create')->with('status', 'role-created');
        }
    }

    public function editRole(Request $request,$id)
    {
        $row = RolesModel::findOrFail($id);
        $data_v['title'] = 'Edit Role';
        $data_v['title_sub'] = 'Edit Role';
        array_push($this->breadcrumb, ['title' => 'Users','url' => '/'.config('app.backend') . '/users','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Group/Role User','url' => '/'.config('app.backend') . '/users/roles','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Edit','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['id'] = $row->id;
        $data_v['name'] = $row->name;
        return view('users::'.$this->theme.'.roles.update')->with($data_v);
    }

    public function updateRole(Request $request, $id)
    {
        $messages = [
            'name.unique' => 'Role sudah ada.',
        ];
        $validator = Validator::make($request->all(),[
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,'.$id]
        ],$messages);
        if($validator->fails()){
            return Redirect::route('users.roles.update',['id' => $id])->withErrors($validator)->withInput();
        }
        $save = RolesModel::find($id)->update(['name' => $request->name, 'updated_by' => \Auth::user()->id]);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Update Role :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Merubah Role ' . $request->name);
            return Redirect::route('users.roles.update',['id' => $id])->with('status', 'role-updated');
        }
    }

    public function destroyRole(Request $request)
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
        $row = RolesModel::where('id', '=', $pid)->where('id', '<>', '1')->first();
        if ($row) {
            $name = $row->name;
            $check = $this->checkExistRole($pid);
            if ($check) {
                return response()->json(['status' => 'error', 'pid' => $pid, 'judul' => 'Failed!', 'pesan' => 'Role ' . $name . ' masih terkait dengan data lainnya']);
            } else {
                $delete = RolesModel::where('id', '=', $pid)->where('id', '<>', '1')->delete();
                if ($delete) {
                    \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete Role :' . $name, \Auth::user()->id);
                    return response()->json(['status' => 'success', 'pid' => $pid, 'pesan' => 'Data ' . $name . ' telah berhasil di hapus']);
                }
            }

        }
    }

    public function destroyRoleAll(Request $request)
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
            $row = RolesModel::where('id', '=', $pid)->where('id', '<>', '1')->first();
            if ($row) {
                $name = $row->name;
                $check = $this->checkExistRole($pid);
                if ($check) {

                } else {
                    $delete = RolesModel::where('id', '=', $pid)->where('id', '<>', '1')->delete();
                    if ($delete) {
                        $i++;
                        array_push($array_pid_sukses, array('pid' => $pid, 'name' => $name));
                    }
                }
            }
        }
        if($i > 0) {
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Delete ' . $i . ' Role', \Auth::user()->id);
            return response()->json(['status' => 'success', 'array_pid_sukses' => $array_pid_sukses, 'judul' => 'Sukses!', 'pesan' => $i . ' data berhasil dihapus']);
        }else{
            \App\Helpers\NumesaHelper::log('CRITICAL', 'Gagal Delete ', \Auth::user()->id);
            return response()->json(['status' => 'error', 'judul' => 'Gagal!', 'pesan' => 'Data gagal dihapus']);
        }
    }

    public function checkExistRole($role_id)
    {
        $exist = FALSE;
        if(RoleHasPermissionsModel::where('role_id','=',$role_id)->exists()){
            $exist = TRUE;
        }
        return $exist;
    }

    public function editPermission(Request $request,$id)
    {
        $role = Role::where('id',$id)->first();
        $this->role = $role;
        $data_v['title'] = 'Edit Permission';
        $data_v['title_sub'] = 'Edit Permission';
        array_push($this->breadcrumb, ['title' => 'Users','url' => '/'.config('app.backend') . '/users','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Group/Role User','url' => '/'.config('app.backend') . '/users/roles','active' => false]);
        array_push($this->breadcrumb, ['title' => 'Permission','url' => '#','active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['id'] = $role->id;
        $data_v['name'] = $role->name;
        $list_permissions = Permission::all();
        $checked_permissions = $this->role->permissions->pluck('name')->toArray();

        $permissions_by_group = [];
        foreach ($list_permissions ?? [] as $permission) {
            $ability = Str::after($permission->name, ' ');
            $permissions_by_group[$ability][] = $permission;
        }
        ksort($permissions_by_group);
        $arr_permissions = [];
        foreach ($permissions_by_group as $group => $permissions){
            $array_temp = [];
            foreach ($permissions as $permission ){
                $tipe = Str::before($permission->name, ' ');
                $checked = in_array($permission->name,$checked_permissions) ? 'checked' : '';
                $array_temp[$tipe] = ['id' => $permission->id, 'name' => $permission->name,'tipe' => $tipe, 'checked' => $checked];
            }
            $arr_permissions[$group] = $array_temp;
        }
        $data_v['arr_permissions'] = $arr_permissions;
        return view('users::'.$this->theme.'.roles.permission')->with($data_v);
    }

    public function updatePermission(Request $request, $id)
    {
        $role = Role::where('id',$id)->first();
        $this->role = $role;
        $this->role->syncPermissions($request->checkbox);
        \App\Helpers\NumesaHelper::log('INFO','Assign Permission :'.$role->name, \Auth::user()->id);
        \Session::flash('messages','Berhasil Assign Permission ke '.$role->name);
        return Redirect::route('users.roles.permission',['id' => $id])->with('status', 'permission-updated');
    }
}
