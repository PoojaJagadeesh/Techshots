<?php

namespace App\Http\Controllers\Frontend\Premium;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class PremiumArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $news =  News::where('is_premium',1)->with(['images'])->get();



            $data['news']   = $news;

            return view('frontend.premium.index',compact('data'));
    }

}
