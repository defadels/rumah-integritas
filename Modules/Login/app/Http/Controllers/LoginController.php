<?php

namespace Modules\Login\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
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
        return view('login::' . $this->theme . '.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('login::create');
    }

    public function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password'), 'is_active' => 1];
        }
        elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('email'), 'password'=>$request->get('password'), 'is_active' => 1];
        }
        return ['username' => $request->get('email'), 'password'=>$request->get('password'), 'is_active' => 1];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        if (Auth::attempt($this->credentials($request),$request['remember'])) {
            $request->session()->regenerate();
            return redirect()->intended(route('app.backend', absolute: false));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('login::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('login::edit');
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
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    protected function authenticated(Request $request)
    {
        User::update([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $request->getClientIp()
        ]);
    }
}
