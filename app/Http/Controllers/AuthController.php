<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function loginpage() {
        return view('login');
    }

    public function login(Request $request) {

        if($request->remember) {
            Cookie::queue('mycookie', $request->email, 30);
        }

        if(Auth::attempt(['username'=>$request->username, 'password'=>$request->password], true)){
            return redirect('/');
        }
        return redirect()->back()->with(['error' => 'Nama Pengguna atau Kata Sandi salah.']);
    }

    public function logout() {
        Auth::logout();
        return redirect('/login');
    }
}
