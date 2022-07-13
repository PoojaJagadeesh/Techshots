<?php

namespace App\Http\Controllers\Auth\Frontend;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }



    protected function attemptLogin(Request $request)
    {
        $validatedData = $request->validate([
                    'email'     => 'required|string',
                    'password'  => 'required|string',
                    ]);

        $credentials = $validatedData;

        if(Auth::guard('web')->attempt($credentials))
        {
            if(auth()->user()->can('checkplan',User::class)){
                return redirect()->intended(route('userdashboard'));
            }else{
                return redirect()->intended(route('userdashboard'));
            }
        }
        else{
            return redirect()->intended(route('premiumlogin'));
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('userdashboard');
    }
    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'email'     => 'required|string',
            'password'  => 'required|string',
        ];

        $validator = Validator::make($request->all(),$rules,[
            'password.required' => 'Password is required.',
            'email.required' => 'Email is required.',
        ]);
        return $validator;
    }
}
