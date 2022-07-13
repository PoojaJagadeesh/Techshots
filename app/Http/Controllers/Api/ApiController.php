<?php

namespace App\Http\Controllers\Api;

use Auth;
use Carbon\Carbon;
use App\Models\News;
use App\Models\User;
use App\Models\Discover;
use App\Models\Infograph;
use App\Models\StatusBar;
use App\Models\ScoreBoard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Http\Resources\DiscoverResource;
use App\Http\Resources\InfographResource;
use App\Http\Resources\StatusBarResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ScoreBoardResource;
use App\Models\Scratch_offer;


class ApiController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $statusBar = StatusBar::select('*')->whereDate('display_date', '<=',$today)
        ->orderByDesc('display_date')->orderByDesc('created_at')
        ->selectRaw('DAY(display_date) as day_of_display')->take(10)->get();

        return StatusBarResource::collection($statusBar);
    }

    public function news()
    {
        $today = Carbon::today()->toDateString();
        $news = News::select('*')->whereDate('display_date', '<=',$today);
        $news=(Auth::user()->is_prime != 1) ? $news->whereNull('is_premium'): $news;

        $news=$news->orderByDesc('created_at')->take(10)->get();
        return NewsResource::collection($news);
    }

    public function add_news_to_favouites(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'news_id' =>'required|exists:news,id',
           ],[]);

           if($validator->fails()){
              return response()->json(['message'=>'invalid','errors'=>$validator->errors()], 401);
           }else{
               $news=News::find($request->input('news_id'));
               $user=User::find(Auth::user()->id);
               if(auth()->user()->news->contains($news->id)){
                auth()->user()->news()->detach($news->id);
               }else{
                auth()->user()->news()->attach($news->id);
               }
            return response()->json(['message'=>'success'], 200);
           }
    }

    public function discover()
    {
        $discover = Discover::orderByDesc('created_at')->paginate(10);
        return DiscoverResource::collection($discover);
    }
    public function scoreboard()
    {
        $scoreboard = ScoreBoard::orderByDesc('created_at')->paginate(10);
        return ScoreBoardResource::collection($scoreboard);
    }
    public function infograph()
    {
        $infofraphs = Infograph::orderByDesc('created_at')->paginate(10);
        return InfographResource::collection($infofraphs);
    }

    public function fetch_all_offers(){
      $user_scrath_card_with_offer =  auth()->user()->scratches_with_gift()
      ->whereHas('scratch_card_info',function($q){
          $q->where('scratchable_type',Scratch_offer::class);
      })
      ->get()->pluck('card_info')->toArray();
     
      $user_reedemed_coupon_offers =  auth()->user()->list_reedemed_coupons()
      ->select('description')->get(['created_at'])->toArray();
    //  ->get()->toArray();
     // ->select(['description','title as offer_title','code as offer_code','validity as valid_date','created_at'])->toArray();

      dd($user_reedemed_coupon_offers);
    }
}
