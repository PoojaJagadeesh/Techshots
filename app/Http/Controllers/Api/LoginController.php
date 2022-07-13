<?php

namespace App\Http\Controllers\Api;

use Hash;
use Exception;
use Socialite;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Userlink;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends Controller
{
    protected $data = [];

    public function __construct()
    {

        $this->data = [
            'status' => false,
            'code' => 401,
            'data' => null,
            'error' => [
                'code' => 1,
                'message' => 'Unauthorized'
                ]
        ];

    }


    public function login(Request $request): JsonResponse
    {
        // $googleAuthCode='eyJhbGciOiJSUzI1NiIsImtpZCI6Ijc4M2VjMDMxYzU5ZTExZjI1N2QwZWMxNTcxNGVmNjA3Y2U2YTJhNmYiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiI5MDE1OTY5MzM5MDMtb3IxZmlwaWlkbmdnc2RlaWxhaXEzOG9qMGluNHNyY3MuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI5MDE1OTY5MzM5MDMtYjhxcXVvY285bHQ5M2R2Y3VwYWpiOHJsbGZvYnRwcnUuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMDIyNDQ0MjA2MDI3MzYzMDQxMDYiLCJlbWFpbCI6ImFueGlhbHRlY2hub2xvZ2llc0BnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwibmFtZSI6IkFueGlhbCBUZWNobm9sb2dpZXMiLCJwaWN0dXJlIjoiaHR0cHM6Ly9saDYuZ29vZ2xldXNlcmNvbnRlbnQuY29tLy1OX2RScUg4NFU1dy9BQUFBQUFBQUFBSS9BQUFBQUFBQUFBQS9BTVp1dWNrN0tidDBPbVo0SHY4NXRrRTdhY1BYX0c2aHdnL3M5Ni1jL3Bob3RvLmpwZyIsImdpdmVuX25hbWUiOiJBbnhpYWwiLCJmYW1pbHlfbmFtZSI6IlRlY2hub2xvZ2llcyIsImxvY2FsZSI6ImVuLUdCIiwiaWF0IjoxNjExMTQzMTQwLCJleHAiOjE2MTExNDY3NDB9.xn3qcRUY9dlbScZW2ZHFbIpMHK48uoOwpM0LtGki2v68dXotYUDq8LJ8EAzWjFJoPKKtAfRtT5mI8lpFW9e0Q1kQXNC-Oe98dTiuq08pa5qE_SsFoDC3ycskguVl46KduoiJR8N7SwSt2FxW6PTVO2y0E26ZTflj5roSuDPF1aAMr0F37XR3PeKwkB6Elmn26NJMgEKMm4QH7QweV_ksastf_RGzAlJ5iMQHKxJkQ3wAADrGiSa9-DAxYRaXw-G77ry55jkEwLQ9N8pKuXudR4cP6IVu1OZQfDgDwgDv5gLC3lBmRABVQQnXPX3ck8DHg8k6QaeQpES7LSJCO3dwFQ';
        // $accessTokenResponse= Socialite::driver('google')->getAccessTokenResponse($googleAuthCode);
        // $accessToken=$accessTokenResponse["access_token"];
        // $expiresIn=$accessTokenResponse["expires_in"];
        // $idToken=$accessTokenResponse["id_token"];
        // $refreshToken=isset($accessTokenResponse["refresh_token"])?$accessTokenResponse["refresh_token"]:"";
        // $tokenType=$accessTokenResponse["token_type"];
        //   $user = Socialite::driver('google')->userFromToken($accessToken);
        //return response()->json(['data'=>$accessTokenResponse],200);

         $validator=Validator::make($request->all(),[
          'email' =>'required|email'
         ],['email.email'=>'Invalid email address format.']);

         if($validator->fails()){
            $this->data['error']['message'] = 'Invaild attempt !';
            $this->data['error']['errors'] = $validator->errors();
            $this->data['code'] = 401;
            return response()->json($this->data, $this->data['code']);
         }else{

            $credentials = $request->only(['email']);
            $user=$this->checkUserExistence($credentials);
            try {
                if(!$user)
                {
                    // create user in not exists
                    $userData   = User::create([
                                        'name'      => ($request->name) ? $request->name: 'test',
                                        'email'     =>  $request->email,
                                        'password'  => Hash::make('techshot111'),
                                        'email_verified_at' => Carbon::now(),
                                    ]);

                    $link       = new Userlink([ 'link' => generate_lilnk_id()]);

                    $userData->user_link()->save($link);

                    $plan = Plan::where('slug', 'trial-plan')->first();

                    $userData->plans()->attach($plan->id,['status' => 0,'created_at' => now()]);

                    if(!$token = JWTAuth::fromUser($userData)){ // generate token for new created user
                        throw new Exception('invalid_credentials');
                    }
                }else if($user->is_active != 1){  // block inactive users
                    $this->data['error']['message'] = 'Access Denied!.';
                    $this->data['code'] = 401;
                    return response()->json($this->data, $this->data['code']);
                }else if($user->is_active == 1){
                    if(!$token = JWTAuth::fromUser($user)){ // if user is exists generate token
                        throw new Exception('invalid_credentials');
                    }
                }

                $this->data = ['status' => true,'code' => 200, 'data' => ['_token' => $token],'error' => null];

           }catch (Exception $e) {
                $this->data['error']['message'] = $e->getMessage();
                $this->data['code'] = 401;
           } catch (JWTException $e) {
                $this->data['error']['message'] = 'Could not create token';
                $this->data['code'] = 500;
           }

           return response()->json($this->data, $this->data['code']);

         }


        // $request->merge(['is_active' => 1,]);
        // $credentials = $request->only(['email', 'password']);

        // try {
        //     if (!$token = JWTAuth::attempt($credentials))
        //     {
        //         throw new Exception('invalid_credentials');
        //     }
        //     $this->data = [
        //         'status' => true,
        //         'code' => 200,
        //         'data' => [
        //             '_token' => $token
        //             ],
        //         'err' => null
        //     ];
        // } catch (Exception $e) {
        //     $this->data['err']['message'] = $e->getMessage();
        //     $this->data['code'] = 401;
        // } catch (JWTException $e) {
        //     $this->data['err']['message'] = 'Could not create token';
        //     $this->data['code'] = 500;
        // }

        // return response()->json($this->data, $this->data['code']);

    }

    public function register(RegisterRequest $request): JsonResponse
    {
        // dd($request->all());
        $validatedData   = $request->validated();
        $user   = User::create([
                    'name'      => $validatedData['name'],
                    'email'     => $validatedData['email'],
                    'password'  => Hash::make($validatedData['password'])
                ]);

        $this->data = [
                    'status' => true,
                    'code' => 200,
                    'data' => [
                            'User' => $user
                        ],
                    'error' => null
                ];

        return response()->json($this->data, $this->data['code']);
    }

    public function detail(): JsonResponse
    {
        $this->data = [
            'status' => true,
            'code' => 200,
            'data' => [
                    'User' => auth()->user()
                ],
            'error' => null
        ];
        return response()->json($this->data);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();
        JWTAuth::invalidate(JWTAuth::getToken());
        $data = [
                'status' => true,
                'code' => 200,
                'data' => [
                            'message' => 'Successfully logged out'
                        ],
                'error' => null
                ];

        return response()->json($data);
    }

    public function refresh(): JsonResponse
    {
        $data = [
            'status' => true,
            'code' => 200,
            'data' => [
                        '_token' => JWTAuth::refresh()
                    ],
            'error' => null
            ];

        return response()->json($data, 200);

    }

    public function checkUserExistence($credentials){
        $emdata=User::whereEmail($credentials['email'])->first();
        return $emdata;
    }
}
