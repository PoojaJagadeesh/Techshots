<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\StatusBar;
use App\Http\Resources\StatusBarResource;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class StatusController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $statusBar = StatusBar::select('*')->whereDate('display_date', '<=',$today)
        ->orderByDesc('display_date')->orderByDesc('created_at')
        ->selectRaw('DAY(display_date) as day_of_display')->take(10)->get();
        
        return StatusBarResource::collection($statusBar);
    }
}
