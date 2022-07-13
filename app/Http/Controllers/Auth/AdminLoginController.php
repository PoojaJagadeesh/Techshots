<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm()
    {
        return view('auth.admin.login');
    }

    protected function attemptLogin(Request $request)
    {
        $request->validate([
                    'email' => 'required|string',
                    'password' => 'required|string',
                    ]);
        $credentials = $request->only('email', 'password');
        if(Auth::guard('admin')->attempt($credentials))
        {
            return redirect()->route('admin.dashboard');
        }
        else{
            return redirect()->intended(route('admin.login'));
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login');
    }
}
