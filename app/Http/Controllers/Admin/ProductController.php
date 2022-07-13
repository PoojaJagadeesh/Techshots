<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Image;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $news = Product::with(['images'])->get();
            return Datatables::of($news)
                ->addIndexColumn()
                ->editColumn('heading', function($news){
                    return isset($news->heading)? $news->heading :'-' ;
                })
                ->editColumn('actual_price', function($news){
                    return isset($news->actual_price)? $news->actual_price :'-' ;
                })
                ->editColumn('discount_price', function($news){
                    return isset($news->discount_price)? $news->discount_price :'-' ;
                })
                ->editColumn('button_label', function($news){
                    return isset($news->button_label)? $news->button_label :'-' ;
                })
                ->addColumn('display_date',function($news){
                    return isset($news->display_date)? Carbon::createFromFormat('Y-m-d', $news->display_date)->format('F, d, Y') :'-' ;
                })
                ->addColumn('bg_img',function($news){
                    return isset($news['images']['img']) ? asset('storage/'.$news['images']['img']) : '-';
                })
                ->addColumn('action',function($news){
                    $actionBtn = '<a href="'.route('products.edit',['product'=>$news->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$news->id.'" class="delete btn btn-danger btn-sm newtrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.product._create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //

        $validator=$this->checkValidation($request);

        if($validator->fails()){

            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
        $news = new Product;
        $news->fill($data);
        $news->save();

        $img            = $request->img;
        $imgPath        = 'images/product/';

        $img_name       = 'product'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

        $image  = new Image;
        $image->img   = $imgPath.$img_name;

        $img->storeAs($imgPath, $img_name, 'public');

        $news->images()->save($image);
        return redirect()->route('products.index')->with('success','Product created successfully!');
    }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {

}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
        $data=[];
        $data['newsdata']=$product; $data['enbldEdit']=true;
        return view('admin.product._create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
        $validator=$this->checkValidation($request,$product->id);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $product->fill($data);
            $product->save();
            if($request->hasFile('img')){
                $current_images=$product->images;
                if($current_images)
                Storage::disk('public')->delete([$current_images->img]);
                $product->images()->delete();

                $img=$request->file('img');
                $imgPath        = 'images/product/';
                $img_name       = 'product'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

                $image  = new Image;
                $image->img   = $imgPath.$img_name;
                $img->storeAs($imgPath, $img_name, 'public');
                $product->images()->save($image);
             }
             return redirect()->route('products.index')->with('success','Updated successfully!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Request $request)
    {
        //
      
        if ($request->ajax()) {
            $validator=Validator::make($request->all(),[
                'statsid' => 'required|exists:products,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $news_data=$product;
                $current_images=$news_data->images;
               if($current_images)
               Storage::disk('public')->delete([$current_images->img]);
               $news_data->images()->delete();
               $news_data->delete();
               return response()->json(['status' => 'success']);
            }
        }
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'heading'=>'required|string|unique:products,heading,'.$id,
            'description'=>'required|string',
            'actual_price'=>'nullable|required|regex:/^\d+(\.\d{1,2})?$/',
            'discount_price'=>'nullable|required|regex:/^\d+(\.\d{1,2})?$/',
            'display_date'=>'nullable|required|date_format:Y-m-d',
            'button_label'=>'nullable|required|string',
        ];
        if(isset($id) && ($bg_img=Product::find($id)->images)){
            $rules['img']='nullable|mimes:jpeg,png,jpg,svg';
        }else{
            $rules['img']='required|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'heading.required' => 'Heading is required.',
            'description.required'=>'Content is required.',
            'img.required'=>'Background image is required.',
        ]);
        return $validator;
    }

}
