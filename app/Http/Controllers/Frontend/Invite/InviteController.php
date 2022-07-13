<?php

namespace App\Http\Controllers\Frontend\Invite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Userlink;
use App\Models\User;
use App\Traits\CoinManagementTrait;
use App\http\Resources\UserScratchCartResource;
use App\Traits\ShareableTrait;

class InviteController extends Controller
{
    use CoinManagementTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $data=[];
       if($request->has('link')){
           $user=Userlink::where('link',$request->link)->with('user_data')->get()->toArray();
          // dd($user->toArray());
           $data['user']=$user[0]['user_data'];

       }
       return view('frontend.invite.index',compact(['data']));
    }


}
