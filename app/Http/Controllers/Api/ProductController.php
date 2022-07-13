<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;
use Carbon\Carbon;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function products(){
        $today = Carbon::today()->toDateString();
        $products = Product::select('*')->whereDate('display_date', '<=',$today);
        $products = $products->orderByDesc('display_date')->orderByDesc('created_at')->paginate(10);

        $response['data'] =  ProductResource::collection($products);
        $response['error'] = null;
        $response['message'] = 'success';
        $response['code']  = 200;
        return response()->json($response,$response['code']);
    }
}
