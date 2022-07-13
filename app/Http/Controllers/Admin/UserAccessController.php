<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;


class UserAccessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax())
        {
            $users  = User::with(['plans'])->select('id','name','email','is_active','is_prime')->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('name', function($users){
                    return isset($users->name) ? $users->name:'-' ;
                })
                ->editColumn('email', function($users){
                    return isset($users->email) ? $users->email:'-' ;
                })
                ->addColumn('action',function($users){
                    $checkStatus=($users->is_active === 1) ? 'checked':'';

                    $actionBtn = '<label class="switch"><input type="checkbox" class="activation_toggle" '.$checkStatus.' data-sid="'.$users->id.'"><span class="slider round"></span></label>&nbsp<a href="javascript:void(0)" data-sid="'.$users->id.'" class="delete btn btn-danger btn-sm statrash"><i class="fa fa-trash"></i></a>&nbsp';

                    $actionBtn .=  '<a href="'.route('front-end-users.premium_user_activity',['uid'=>$users->id]).'" class="uselog btn btn-info btn-sm"><i class="fa fa-history"></i></a>';
                    return $actionBtn;
                })
                ->addColumn('is_premium', function($users){
                    $prm_stats='-';
                    if(count($users->plans)){
                        $prm_stats  = 'Yes ';
                        $prm_stats .= ($users->plans()->where('status', 0)->count() > 0) ? '<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Expired</span>';
                    }
                    else{ $prm_stats='No'; }
                    return $prm_stats ;
                })
                ->rawColumns(['action','is_premium'])
                ->make(true);

        }
    return view('admin.frontend-users.index');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function coinindex(Request $request)
    {
        if ($request->ajax())
        {
            $users  = User::WhereHas('active_coins')->with(['plans'])->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('name', function($users){
                    return isset($users->name) ? $users->name:'-' ;
                })
                ->editColumn('email', function($users){
                    return isset($users->email) ? $users->email:'-' ;
                })
                ->editColumn('active_coins.active_coin_nums', function($user){
                    return ($user->active_coins()->exists()) ? $user->active_coins->active_coin_nums : 0 ;
                })
                ->addColumn('action',function($users){

                    $actionBtn =  '<a href="'.route('front-end-users.show_coin_reedem_log',['uid'=>$users->id]).'" class="uselog btn btn-info btn-sm"><i class="fa fa-history"></i></a>';
                    return $actionBtn;
                })
                ->addColumn('is_premium', function($users){
                    $prm_stats='-';
                    if(count($users->plans)){
                        $prm_stats  = 'Yes ';
                        $prm_stats .= ($users->plans()->where('status', 0)->count() > 0) ? '<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Expired</span>';
                    }
                    else{ $prm_stats='No'; }
                    return $prm_stats ;
                })
                ->rawColumns(['action','is_premium'])
                ->make(true);

        }
        return view('admin.frontend-users.coinRedeemIndex');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function scratchindex(Request $request)
    {
        if ($request->ajax())
        {
            $users  = User::whereHas('all_gained_scratches')
                            ->with(['plans'])->select('id','name','email','is_active','is_prime')->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->editColumn('name', function($users){
                    return isset($users->name) ? $users->name:'-' ;
                })
                ->editColumn('email', function($users){
                    return isset($users->email) ? $users->email:'-' ;
                })
                ->addColumn('action',function($users){


                    $actionBtn =  '<a href="'.route('front-end-users.show_scratch_attempts',['uid'=>$users->id]).'" class="uselog btn btn-info btn-sm"><i class="fa fa-history"></i></a>';
                    return $actionBtn;
                })
                ->addColumn('is_premium', function($users){
                    $prm_stats='-';
                    if(count($users->plans)){
                        $prm_stats  = 'Yes ';
                        $prm_stats .= ($users->plans()->where('status', 0)->count() > 0) ? '<span class="badge badge-success">Active</span>':'<span class="badge badge-danger">Expired</span>';
                    }
                    else{ $prm_stats='No'; }
                    return $prm_stats ;
                })
                ->rawColumns(['action','is_premium'])
                ->make(true);

        }
    return view('admin.frontend-users.scratchedAttemptsIndex');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $front_end_user,Request $request)
    {
        if($request->ajax()){
            $validator=Validator::make($request->all(),[
                'statsid' => 'required|exists:users,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $user_data=$front_end_user;
                $user_data->delete();
                return response()->json(['status' => 'success']);
            }
        }
    }

    public function disable_user(Request $request){
        if($request->ajax()){
            $validator=Validator::make($request->all(),[
                'uid' => 'required|integer|exists:users,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $user_data=User::find((int)$request->input('uid'));
                $user_data->is_active=$request->input('status') == 1 ? 1:0;
                if($user_data->save())
                return response()->json(['status'=>'success']);
            }
        }
    }

    public function show_premiumUserActivity(Request $request,$uid){
        $data               = [];
        $user               =  User::with(['active_coins','plans'])->find((int)$uid);
        $data['user_data']  =  $user;

        $data['remaining_active_coins'] =  ($user->active_coins) ? number_format($user->active_coins->active_coin_nums) : 0;
        $coins_acc=User::find((int)$uid)->own_coins()->get();//->groupBy('user_acquired_coins.type');
       // dd($coins_acc);
        if($request->ajax()){
            return Datatables::of($coins_acc)
                ->addIndexColumn()
                ->editColumn('nums', function($users){
                    return isset($users->nums) ? $users->nums:'-' ;
                })
                ->editColumn('type', function($users){
                    if($users->type==0){
                      $type="Regular token";  
                    }else{
                        $type="Scratched";
                    }
                    return isset($type) ? $type:'-' ;
                })
                ->addColumn('created_at',function($users){
                   
                    return isset($users->created_at)?date('d-m-Y'):"-";
                })
                
                ->rawColumns(['action','type'])
                ->make(true);
            }
        
    
        // $coins_arr=array_values($coins_acc);
        // if(count($coins_arr)>0){
        // $data['coin_gifted']=$coins_arr[0][1];
        // $data['coin_scratched']=$coins_arr[0][0];
        // }else{
        //     $data['coin_gifted']=null;
        //     $data['coin_scratched']=null;
        // }
        
        
        $data['user_plan']              =   $user['plans'];
        $data['is_premium']             =  count($user->plans) ? true:false;
        $planData                       =   $user->plans()->where('status', 0);

        if($planData->count() > 0){
            $data['premium_status'] =   true;
            $data['premium_type'] =  $planData->get()[0];
          // dd($data['premium_type']->toArray());
        }else{
            $data['premium_status'] =   false;
            $data['premium_type'] =   null;
        }

        return view('admin.frontend-users.userActivityLog',compact('data'));
    }

    public function show_userCoin_Reedem_Log(Request $request){
        $user               =  User::with(['coin_reedem_trans'])->find($request->uid);
        if($request->ajax()){
            return Datatables::of($user->coin_reedem_trans)
                                ->addIndexColumn()
                                ->editColumn('type', function($coin_reedem_log){
                                    $type=  '-';
                                    if($coin_reedem_log->type === 0){ $type= 'coupon';  }
                                    else if($coin_reedem_log->type === 1){ $type= 'cash'; }
                                    return $type;
                                })
                                ->editColumn('coin_nums_reedemed',function($coin_reedem_log){
                                    return isset($coin_reedem_log->coins_reedemed)? $coin_reedem_log->coins_reedemed :'-' ;
                                })
                                ->editColumn('coupon_card_title',function($coin_reedem_log){
                                    $title= '-';
                                    if($coin_reedem_log->type === 0 && isset($coin_reedem_log->coupon_data)){
                                        $title =  $coin_reedem_log->coupon_data->title;
                                    }
                                    return $title;
                                })
                                ->editColumn('reedemed_cash',function($coin_reedem_log){
                                    $reedemed_cash =  '-';
                                    if($coin_reedem_log->type === 1 && isset($coin_reedem_log->reedemed_cash)){
                                        $reedemed_cash =  $coin_reedem_log->reedemed_cash;
                                    }
                                    return $reedemed_cash;
                                })
                                ->editColumn('reedemed_at',function($coin_reedem_log){
                                    return isset($coin_reedem_log->created_at) ? $coin_reedem_log->created_at->format("F j, Y") :'-' ;
                                })
                                ->make(true);
        }
        return view('admin.frontend-users.coinRedeemLog',compact('user'));
    }

    public function show_userScratch_Attempts(Request $request){
        $data               = [];
        $user               =  User::with(['active_coins','plans'])->find((int)$request['uid']);
        $data['user_data']  =  $user;
        if($request->ajax()){
            $userid =  (int)$request->input('user_entity');

            $scratch_attempt_log =  User::find($userid)->all_gained_scratches()
            ->where(function($q){
                $q->where('is_scratched','!=',1)
                ->orWhere(function($q){
                    $q->where('is_scratched','=',1)
                      ->where('is_gift_granted','=',1)
                      ->whereNotNull('scratch_card_id');
                  });
               })
            ->get();


            return Datatables::of($scratch_attempt_log)
            ->addIndexColumn()
            ->addColumn('gift_type', function($scratch_attempt_log){
                $type=  '-';
                if(isset($scratch_attempt_log->card_info['type'])){
                  $type =  $scratch_attempt_log->card_info['type'] == 'offer' ? 'offer' : ($scratch_attempt_log->card_info['type'] == 'coin' ? 'coin' : 'N/A');
                }else{
                  $type = 'No Gift';
                }
                return $type;
            })
            ->addColumn('coin_nums',function($scratch_attempt_log){
                return isset($scratch_attempt_log->card_info['equivalent_coins'])? $scratch_attempt_log->card_info['equivalent_coins'] :'-' ;
            })
            ->addColumn('offer_title',function($scratch_attempt_log){
                return isset($scratch_attempt_log->card_info['offer_title'])? $scratch_attempt_log->card_info['offer_title'] :'-' ;
            })
            ->addColumn('is_scratched',function($scratch_attempt_log){
                $scratch_status = '-';
                if($scratch_attempt_log->is_scratched === 1){
                    $scratch_status = 'Yes';
                }else if($scratch_attempt_log->is_scratched === 0){
                    $scratch_status = 'No';
                }
                return $scratch_status;
            })
            ->make(true);
        }
        return view('admin.frontend-users.scratchedAttemptsLog',compact('data'));
    }
}
