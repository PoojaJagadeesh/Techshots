<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ScratchCardsTrait;

class ScratchActionController extends Controller
{
    use ScratchCardsTrait;

    public function __construct()
    {
       // $this->middleware('checkSubscription')->only(['create_showScratches','showexpecting_andGiftedScratches','perform_scratchAction']);
       // $this->middleware('can:checkplan,App\Models\User')->only(['create_showScratches','showexpecting_andGiftedScratches','perform_scratchAction']);
    }

    public function create_showScratches(){
        $response=$this->initiate_new_scratchAndFetch();
        return response()->json($response,$response['code']);

    }

    public function perform_scratchAction(Request $request){
        $response=$this->scratch_theCard($request);
        return response()->json($response,$response['code']);
    }

}
