<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index', [
            'title' => 'Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'login' => 'required|string', // email or username
            'password' => 'required'
        ]);

        // allow login using email OR username — check format and build credentials accordingly
        $loginField = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [$loginField => $data['login'], 'password' => $data['password']];

        if (Auth::attempt($credentials)) {
            // update last login timestamp for auditing
            $user = Auth::user();
            if ($user) {
                $user->update(['last_login_at' => now()]);
            }

            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('LoginError', 'Login gagal — periksa email/username dan kata sandi Anda.');
    }

    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();

        request()->session()->regenerate();

        return redirect('/');
    }
}
