<?php

namespace App\Livewire;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class FormLogin extends Component
{

    public $email;
    public $password;

    public function render()
    {
        return view('livewire.form-login')->layout('layouts.login');
    }

    public function login()
    {
        $this->validate([
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
        if(Auth::attempt(['email' => $this->email, 'password'=> $this->password])) {
            return redirect()->intended(route('backend', absolute: false));
        } else {
            session()->flash('error', 'Alamat Email atau Password Anda salah!.');
            return redirect()->intended(route('form.login', absolute: false));
        }
        //$this->$request->authenticate();
        //return redirect()->route('admin.dashboard');

        //$this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }

}
