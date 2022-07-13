<?php

namespace App\Http\Controllers\Frontend\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $products =  Product::with(['images'])->get();

        return view('frontend.product.index',compact('products'));
    }


}
