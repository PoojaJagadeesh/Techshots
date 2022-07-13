<?php

namespace App\Http\Controllers\Api;

use App\Models\ScoreBoard;
use App\Http\Controllers\Controller;
use App\Http\Resources\ScoreBoardResource;


class ScoreBoardController extends Controller
{
    public function scoreboard()
    {
        $scoreboard = ScoreBoard::orderByDesc('created_at')->paginate(10);
        return ScoreBoardResource::collection($scoreboard);
    }
}
