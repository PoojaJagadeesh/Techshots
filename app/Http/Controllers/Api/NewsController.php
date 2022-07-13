<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\User;
use App\Http\Resources\NewsResource;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function __construct()
    {
      //  $this->middleware('checkSubscription')->only(['news']);
   //   $this->middleware('can:checkplan,App\Models\User')->only(['make_reedem_coupon']);
    }

    public function news()
    {
        $today = Carbon::today()->toDateString();
        $news = News::select('*')->whereDate('display_date', '<=',$today);
        $news =  $news->filternews();
       // $news=(Auth::user()->is_prime != 1) ? $news->whereNull('is_premium'): $news;
        $news=$news->orderByDesc('created_at')->paginate(10);
        return NewsResource::collection($news);
    }

    public function add_news_to_favouites(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'news_id' =>'required|exists:news,id',
           ],[]);
           if($validator->fails()){
              return response()->json(['message'=>'invalid','error'=>$validator->errors()], 401);
           }else{
               $news=News::find($request->input('news_id'));
               if(auth()->user()->news->contains($news->id)){
                auth()->user()->news()->detach($news->id);
               }else{
                auth()->user()->news()->attach($news->id);
               }
            return response()->json(['status'=>true,'message'=>'success','data'=>$news], 200);
           }
    }

    public function fetch_favourites(){
        $favourite_news=News::select('*')->whereHas('users_con',function($q){
            return $q->where('user_id',auth()->user()->id);
        })->paginate(10);
        return NewsResource::collection($favourite_news);
    }

    public function lite_news_infos_toAll(Request $request){
        $today  = Carbon::today()->toDateString();
        $news   =  News::whereDate('display_date', '<=',$today);
        if($request->has('type') && $request->input('type') === 'premium'){
            $news =  $news->where('is_premium',1);
        }
        $news =  $news->get();
        return NewsResource::collection($news);
    }

    public function read_news(Request $request){
        $data =['data'=>[]];
        if($request->has('news') && ($info=News::find((int)$request->input('news'))) ){
            return new NewsResource($info);
        }

        return response()->json($data,200);
    }

    public function add_claps(Request $request){
        $validator=Validator::make($request->all(),[
            'news_id' =>'required|exists:news,id',
           ],[]);
           if($validator->fails()){
              return response()->json(['data'=>[], 'error'=>$validator->errors(), 'message'=>'invalid'], 401);
           }else{
            $news = News::find((int)$request->input('news_id'));
            $news->increment('claps');
            $news->save();
            $data = new NewsResource($news);
            return response()->json(['data'=>$data, 'error'=>null, 'message'=>'success',], 200);
           }  
    }
}
