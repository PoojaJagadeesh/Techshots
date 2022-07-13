<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Discover;
use App\Http\Resources\DiscoverResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class DiscoverController extends Controller
{
    public function discover()
    {
        $discover = Discover::orderByDesc('created_at')->paginate(10);
        return DiscoverResource::collection($discover);
    }
}
