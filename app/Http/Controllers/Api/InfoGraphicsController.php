<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\InfoGraphic;
use App\Http\Resources\InfoGraphicCollection;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class InfoGraphicsController extends Controller
{
   public function infographic(){
    $infograph_datas=InfoGraphic::orderByDesc('created_at')->paginate(10);
    return InfoGraphicCollection::collection($infograph_datas);
   }
}
