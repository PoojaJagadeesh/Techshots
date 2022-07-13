<?php

namespace App\Http\Controllers\Frontend\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Userlink;
use App\Traits\CoinManagementTrait;
use App\http\Resources\UserScratchCartResource;
use App\Traits\ShareableTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    use CoinManagementTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        $user                       = auth()->user()->load('user_link');
        // dd($user);
        $coupon                     = json_decode(json_encode($this->show_reedemedCouponLists()),true);
        $coin                       = json_decode(json_encode($this->retrieve_remainingUserCoins()),true);

        $data['news']               = News::get();
        $news                       = News::whereHas('users_con',function($q){
                                                return $q->where('user_id',auth()->user()->id);
                                            })->get();

        $data['refered']            = auth()->user()->referedUsers()->with(['plans'])->select('id','name','email','is_active','is_prime')->get();
        $data['fav_news']=$news;
        $data['coin']               = $coin['original']['data'];
        $data['coupon']             = $coupon;
       
        $data['coupon_count']       = (isset($coupon)) ? count($coupon) :"-";
        $data['invite_link']        = ($user->user_link()->exists()) ? route('invite').'?link='.$user->user_link->link : '';
        $data['scratch_card']       = auth()->user()->all_gained_scratches()->GiftedOffers()->get();
              //  dd($data['refered']);
        return view('frontend.profile.index',compact(['data']));
    }

    public function changePasswordShow(){
        return view('frontend.profile.change_password');
    }

    public function updatePassword(Request $request){
        $validator=$this->checkValidation($request);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $user = auth()->user();
            $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('profile')->with('success','Updated successfully!');
    }
}



protected function checkValidation(Request $request,$id=null){
    $rules=array();
    $rules=[
        'password' => 'required|string|min:6|confirmed',
        'password_confirmation' => 'required',
    ];

    $validator=Validator::make($request->all(),$rules,[
        'password.required' => 'New password is required.',
        'password_confirmation.required' => 'Confirm password is required.',
    ]);
    return $validator;
}
    }
