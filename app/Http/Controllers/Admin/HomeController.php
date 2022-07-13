<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    public function index()
    {
        $data['users']  = User::all()->count();
        $data['prime']  = User::with(['plans'])->select('id','name','email','is_active','is_prime')->get()->toArray();
     // dd($data);
        return view('admin.home', compact(['data']));
    }
}
