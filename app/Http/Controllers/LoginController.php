<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Auth;

class LoginController extends Controller
{
    public function Login()
    {
        if (auth()->check()) {
            if (auth()->user()->role == 'ctv') {
                return redirect()->route('ctv.Dashboard');
            }
            if (auth()->user()->role == 'manager') {
                return redirect()->route('manager.Dashboard');
            }
            if (auth()->user()->role == 'president') {
                return redirect()->route('president.Dashboard');
            }
        }
        return view('login');
    }
    public function postLogin(LoginRequest $request)
    {
        $remember = $request->has('remember') ? true : false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $remember)) {
            if (auth()->user()->role == 'ctv') {
                return redirect()->route('ctv.Dashboard');
            }
            if (auth()->user()->role == 'manager') {
                return redirect()->route('manager.Dashboard');
            }
            if (auth()->user()->role == 'president') {
                return redirect()->route('president.Dashboard');
            }
            if (auth()->user()->role == 'qlns') {
                return redirect()->route('qlns.Dashboard');
            }
        } else {
            return back()->with('thatbai', 'Sai email hoặc mật khẩu!');
        }
    }

    public function Logout()
    {
        Auth::Logout();
        return redirect()->route('getLogin');
    }
}
