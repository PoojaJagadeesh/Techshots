<?php

namespace App\Http\Controllers\Auth\Frontend;

use Exception;
use App\Models\Plan;
use App\Models\User;
use App\Models\Userlink;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Contracts\Session\Session;


class GoogleOAuthController extends Controller
{

    public function showLogin(Request $request)
    {
        if($request->has('referal_link') && $request->referal_link != '')
        {
            $referal = $request->referal_link;
            return view('auth.frontend.login', compact('referal'));
        }
        return view('auth.frontend.login');

    }
    public function redirectToGoogle(Request $request)
    {
        if ($request->has('referal_link') && $request->referal_link != '') {
            $request->session()->forget('referal_link');
            $request->session()->put('referal_link', $request->referal_link);

            return Socialite::driver('google')
                    ->with(['referal_link' => $request->referal_link])
                    ->redirect();
        } else {
            return Socialite::driver('google')->redirect();
        }

    }


    public function handleGoogleCallback(Request $request)
    {
        try {

            $user       = Socialite::driver('google')->stateless()->user();
            $finduser   = User::where('email', $user->email)->first();

            if($finduser)
            {
                Auth::login($finduser);
            }
            else
            {
                $referalDetails = null;

                if(session()->has('referal_link'))
                {
                    $link   = session('referal_link');

                    $referalDetails = Userlink::where('link',$link)->first()->id ?? null;
                }

                DB::beginTransaction();

                try {
                    $user_array     = [
                            'name'      => $user->name,
                            'email'     => $user->email,
                            'google_id' => $user->id,
                            'password'  => Hash::make('user1234'),
                            'referral_id' => $referalDetails
                                    ];

                    $newUser    = User::create($user_array);

                    $link       = new Userlink([ 'link' => generate_lilnk_id()]);

                    $newUser->user_link()->save($link);

                    $plan = Plan::where('slug', 'trial-plan')->first();

                    $newUser->plans()->attach($plan->id,['status' => 0,'created_at' => now()]);

                    Auth::login($newUser);
                    $request->session()->forget('referal_link');


                    DB::commit();
                } catch (\Throwable $th) {
                    DB::rollBack();
                    dd($th->getMessage());
                    return back()->with([
                        'message'   => $th->getMessage(),
                        'type'      => 'error',
                        'title'     => 'Error'
                    ]);
                }

            }

            if(auth()->user()->can('checkplan',User::class)){
                return redirect()->intended(route('userdashboard'));
            }else{
                return redirect()->intended(route('userdashboard'));
            }

        } catch (Exception $e) {
            dd($e->getMessage());
            return back()->with([
                'message'   => $e->getMessage()
            ]);
        }
    }


}
