<?php

namespace App\Http\Controllers\Frontend\Privacy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    //

    public function showPrivacy()
    {
        //

      
            return view('frontend.policy.privacy');
    }
    public function showPolicy()
    {
        //

      
            return view('frontend.policy.policy');
    }
    public function showTerms()
    {
        //

      
            return view('frontend.policy.terms');
    }
}
