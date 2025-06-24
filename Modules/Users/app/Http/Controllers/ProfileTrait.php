<?php

namespace Modules\Users\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Users\Models\RoleHasPermissionsModel;
use Modules\Users\Models\UsersProfileModel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Modules\Users\Models\RolesModel;
use Modules\Users\Models\UsersModel;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Validation\Rules;

trait ProfileTrait
{

    public function indexProfile(Request $request)
    {
        $user_id = \Auth::user()->id;
        $user = User::findOrFail($user_id);
        $user_profile = UsersProfileModel::where('user_id','=',$user_id)->first();
        $data_v['title'] = 'Akun Saya';
        $data_v['title_sub'] = 'Akun Saya';
        array_push($this->breadcrumb, ['title' => 'Akun Saya', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['id'] = $user->id;
        $data_v['name'] = $user->name;
        $data_v['email'] = $user->email;
        $data_v['role'] = $user->getRoleNames()->first();
        $data_v['last_login_at'] = $user->last_login_at != NULL ? $user->last_login_at->format('d/m/Y H:i:s') : '';
        $data_v['phone'] = $user->phone;
        $data_v['bio'] = $user_profile->bio;
        $data_v['alamat'] = $user_profile->alamat;
        $data_v['keterangan'] = $user_profile->keterangan;
        $data_v['company_name'] = $user_profile->company_name;
        $data_v['website'] = $user_profile->website;
        $data_v['social_facebook'] = $user_profile->social_facebook;
        $data_v['social_twitter'] = $user_profile->social_twitter;
        $data_v['social_instagram'] = $user_profile->social_instagram;
        $data_v['social_linkedln'] = $user_profile->social_linkedln;
        $data_v['social_skype'] = $user_profile->social_skype;
        $data_v['social_github'] = $user_profile->social_github;
        $data_v['file_lama'] = $user->avatar;
        return view('users::'.$this->theme.'.profile.index')->with($data_v);
    }

    public function updateProfile(Request $request)
    {
        $user_id = \Auth::user()->id;
        $messages = [
            /* 'email.unique' => 'Email sudah ada.',*/
        ];
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255']
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('profile')->withErrors($validator)->withInput();
        }

        //upload avatar
        $file_lama = $request->file_lama;
        $fileattach = $request->file('file_attach');
        if($fileattach) {
            $filename = uniqid() . time() . '.' . $fileattach->getClientOriginalExtension();
            $img = Image::read($fileattach)->resize(128, 128, function ($constraint) {
                $constraint->aspectRatio();
            });
            $store = Storage::put('images/avatar/'.$filename, (string) $img->encode());
            if($store){
                //delete file lama
                if($file_lama != '') {
                    $exists = Storage::exists('images/avatar/' . $file_lama);
                    if ($exists == true) {
                        Storage::delete('images/avatar/' . $file_lama);
                    }
                }
            }
        }else{
            $filename = $request->file_lama;
        }

        $save = User::find($user_id)->update(['name' => $request->name, 'phone' => $request->phone, 'avatar' => $filename, 'updated_by' => \Auth::user()->id]);
        $save_profile = UsersProfileModel::find($user_id)->update(['bio' => $request->bio, 'alamat' => $request->alamat,
            'company_name' => $request->company_name, 'website' => $request->website, 'social_facebook' => $request->social_facebook,
            'social_twitter' => $request->social_twitter, 'social_instagram' => $request->social_instagram,
            'social_linkedln' => $request->social_linkedln, 'social_skype' => $request->social_skype,
            'social_github' => $request->social_github, 'updated_by' => \Auth::user()->id]);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Update Profile :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Merubah Profil ' . $request->name);
            return Redirect::route('profile')->with('status', 'profile-updated');
        }
    }

    public function editProfilePassword()
    {
        $user_id = \Auth::user()->id;
        $user = User::findOrFail($user_id);
        $data_v['title'] = 'Ganti Password';
        $data_v['title_sub'] = 'Ganti Password';
        array_push($this->breadcrumb, ['title' => 'Ganti Password', 'url' => '#', 'active' => true]);
        $data_v['breadcrumb'] = $this->breadcrumb;
        $data_v['id'] = $user->id;
        $data_v['name'] = $user->name;
        return view('users::' . $this->theme . '.profile.password')->with($data_v);
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateProfilePassword(Request $request): RedirectResponse
    {
        $user_id = \Auth::user()->id;
        $user = User::findOrFail($user_id);
        $name = $user->name;
        $messages = [
            /* 'email.unique' => 'Email sudah ada.',*/
        ];
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed', Rules\Password::defaults()]
        ], $messages);
        if ($validator->fails()) {
            return Redirect::route('profile.password')->withErrors($validator)->withInput();
        }
        $save = User::find($user_id)->update(['password' => Hash::make($request->password),'updated_by' => \Auth::user()->id]);
        if($save){
            \App\Helpers\NumesaHelper::log('INFO', 'Update Password :' . $request->name, \Auth::user()->id);
            \Session::flash('messages', 'Berhasil Merubah Password User ' . $name);
            return Redirect::route('profile.password')->with('status', 'password-updated');
        }
    }

    public function viewAvatar($filename)
    {
        $exists = Storage::exists('images/avatar/'. $filename);
        if ($exists == true && $filename != '') {
            return response()->file(storage_path() . '/app/images/avatar/' . $filename);
        }else{
            return response()->file(public_path() . '/assets/images/male-avatar.png');
        }
    }
}
