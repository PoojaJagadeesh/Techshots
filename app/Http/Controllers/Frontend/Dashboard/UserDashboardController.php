<?php

namespace App\Http\Controllers\Frontend\Dashboard;

use Auth;
use Carbon\Carbon;
use App\Models\News;
use App\Models\StatusBar;
use Illuminate\Http\Request;
use App\Traits\ShareableTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Http\Resources\StatusBarResource;
use App\Traits\CoinManagementTrait;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    use ShareableTrait,CoinManagementTrait;

    public function index(Request $request)

    {
        $today = Carbon::today()->toDateString();
        if(Auth::check()){
        $response=$this->grant_initialCoinsToUser($request);
       // dd($response);
        }

        $news =  News::whereDate('display_date', '<=',$today)->with(['images'])->orderByDesc('created_at')->paginate(6);

        $data['news']   = $news;

        if($request->has('news'))
        {
            $data['sharable']=true;
            $data['shared_news']= News::with(['images'])->find($request->id);

        }else{
            $data['sharable']=false;
        }


        if ($request->ajax()) {
            $view = view('frontend.dashboard._inifinte',compact('data'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('frontend.dashboard.index',compact('data'));
    }


    public function show($id)
    {
        $news           = News::find($id);
        $data['news']   = $news;
        return view('frontend.userfavourite.sharenews',compact('data'));

    }


    public function getStatus(Request $request){

            $today      = Carbon::today()->toDateString();
            $statusBar  = StatusBar::select('*')->with('images')->whereDate('display_date', '<=',$today)
                                                ->orderByDesc('display_date')
                                                ->selectRaw('DAY(display_date) as day_of_display')
                                                ->take(10)->get();



      //  $status =   StatusBarResource::collection($statusBar);
        return response()->json(['status' =>'success','message' => 'Storeies',"stories"=> $statusBar]);
    }
    public function addToFav(Request $request){
        $validator=Validator::make($request->all(),[
            'news_id' =>'required|exists:news,id',
           ],[]);
           if($validator->fails()){
              return response()->json(['message'=>'invalid','error'=>$validator->errors()], 401);
           }else{
               $news=News::find($request->input('news_id'));
               if(auth()->user()->news->contains($news->id)){
                auth()->user()->news()->detach($news->id);
                $status=0;
               }else{
                auth()->user()->news()->attach($news->id);
                $status=1;
               }

            return response()->json(['status'=>$status,'message'=>'success','data'=>$news], 200);
           }
    }
    public function fetch_favourites(){
        $favourite_news=News::select('*')->whereHas('users_con',function($q){
            return $q->where('user_id',auth()->user()->id);
        })->paginate(10);
        return NewsResource::collection($favourite_news);
    }
    public function shareNews(Request $request)
    {
        $input  = $request->all();
        $news   = News::find($input['id']);

        if($news->is_premium == 1)
        {
            $premium=true;
        }
        else
        {
            $premium=false;
        }
        $link=$news->getShareUrl($input['type'],$news->id,$premium);
        return response()->json(['status'=>"success",'link'=>$link,'data'=>$news], 200);

    }
    public function addClaps(Request $request){
        $input=$request->all();
        //dd($id);
        $news = News::find($input['id']);
        $news->increment('claps');
        $news->save();
        return response()->json(['count'=>$news->claps,'message'=>'success','data'=>$news], 200);
    }


    // public function number_format_short( $n ) {
    //     if ($n > 0 && $n < 1000) {
    //         // 1 - 999
    //         $n_format = floor($n);
    //         $suffix = '';
    //     } else if ($n >= 1000 && $n < 1000000) {
    //         // 1k-999k
    //         $n_format = floor($n / 1000);
    //         $suffix = 'K.';
    //     } else if ($n >= 1000000 && $n < 1000000000) {
    //         // 1m-999m
    //         $n_format = floor($n / 1000000);
    //         $suffix = 'M+';
    //     } else if ($n >= 1000000000 && $n < 1000000000000) {
    //         // 1b-999b
    //         $n_format = floor($n / 1000000000);
    //         $suffix = 'B+';
    //     } else if ($n >= 1000000000000) {
    //         // 1t+
    //         $n_format = floor($n / 1000000000000);
    //         $suffix = 'T+';
    //     }

    //     return !empty($n_format . $suffix) ? $n_format . $suffix : 0;
    // }

    public function grant_initialCoinsToUser(Request $request){
        $data = [];
         DB::beginTransaction();
               try{
                 
               if(!$this->check_current_token()){
                
                       $common_setting=fetch_common_settings();
                       $daily_allowable_coins=isset($common_setting->daily_allowable_coins) ? $common_setting->daily_allowable_coins:5;
                       $user_coin=auth()->user()->own_coins()->create([
                          'nums'  => $daily_allowable_coins,
                           'type' => 0,
                       ]);
                      
                      $this->addToUserActivecoin($daily_allowable_coins);
                      $this->data['status']=true;
                       $this->data['message']='Initial coins created !.';
                       $this->data['data']=$user_coin;
                       $this->data['code']=200;
                     //  dd($data);
                       $data=$this->data;
                       $response=$data;
                       
                       // return $response;
                   }else{
                    
                       $this->data['status']=false;
                       $this->data['message']='Not allowed to create initial coins now';
                       $this->data['data']=null;
                       $this->data['code']=403;
                       $response=$this->data; //return $response;
                   }
                 DB::commit();
               }catch(\Exception $e){
                   DB::rollback();
                   $this->data['status']=false;
                   $this->data['message']=$e->getMessage();
                   $this->data['data']=null;
                   $this->data['code']=403;
                   $response=$this->data;
                  }
                //  dd($response);
               return response()->json($this->data,$this->data['code']);
       }
       public  function check_current_token(){
        $latest_coin=auth()->user()->own_coins()->whereType(0)->latest()->first();  // type 0 stands for regular token
        if(isset($latest_coin) && ($latest_coin->created_at->format('Y-m-d') == date('Y-m-d'))){ // checking any coin added to user today
            return true;
        }else{
            return false;
        }
    }
    public function addToUserActivecoin($incomcoins=null){
        $activeCoin=auth()->user()->active_coins();
       
        if($dat=auth()->user()->active_coins){
            $updated_active_coins=($dat->active_coin_nums + $incomcoins);
           $activeCoin->update(['active_coin_nums'=>$updated_active_coins]);
        }else{
           $activeCoin->create(['active_coin_nums'=>$incomcoins]);
        }
      
       return true;
    }
}
