<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Intervention\Image\Facades\Image as ImageIntervetor;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $coupon=Coupon::with(['images'])->get();
            return Datatables::of($coupon)
                ->addIndexColumn()
                ->editColumn('title', function($coupon){
                    return isset($coupon->title)? $coupon->title :'-' ;
                })
                ->addColumn('thumb_img',function($coupon){
                    return isset($coupon['images']['thumb_img']) ? asset('storage/'.$coupon['images']['thumb_img']) : '-';
                })
                ->addColumn('num_coins', function($coupon){
                    return isset($coupon->equivalent_coins)? $coupon->equivalent_coins :'-' ;
                })
                ->addColumn('valid_date', function($coupon){
                    return isset($coupon->validity)? Carbon::createFromFormat('Y-m-d', $coupon->validity)->format('F, d, Y') :'-' ;
                })
                ->addColumn('created_on', function($coupon){
                    return isset($coupon->created_at)? $coupon->created_at->format('F, d, Y') :'-' ;
                })
                ->addColumn('action',function($coupon){
                    $actionBtn = '<a href="'.route('coupons.edit',['coupon'=>$coupon->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$coupon->id.'" class="delete btn btn-danger btn-sm statrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupons._create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator=$this->checkValidation($request);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $coupon = new Coupon;
            $coupon->fill($data);
            $coupon->save();

            $originalImage=$request->file('thumb_img');
            $thumbImg       = ImageIntervetor::make($originalImage)->resize(50,50)->stream();

            $thumbImgPath   = 'images/coupons/thumb_img/';
            $thumb_img_name     = 'thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();

            $image  = new Image;
            $image->thumb_img   = $thumbImgPath.$thumb_img_name;
            Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);

            $coupon->images()->save($image);
            return redirect()->route('coupons.index')->with('success','Status created successfully!');

        }
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'title'=>'required|string|unique:coupons,title,'.$id.',id,deleted_at,NULL',
            'equivalent_coins'=>'required|integer|min:1',
            'validity'=>'required|date_format:Y-m-d',
            'code' => 'required|string',
        ];
        if(isset($id) && ($bg_img=Coupon::find($id)->images)){
            $rules['thumb_img']='nullable|mimes:jpeg,png,jpg,svg';
        }else{
            $rules['thumb_img']='required|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'title.required' => 'Title is required.',
            'thumb_img.required'=>'Thumb image is required.',
            'equivalent_coins.integer'=>'Invalid number of coins.',
            'code'=> 'Offer code is required.',
        ]);
        return $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $coupon)
    {
        $data=[];
        $data['coupondata']=$coupon; $data['enbldEdit']=true;
        return view('admin.coupons._create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validator=$this->checkValidation($request,$coupon->id);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $coupon =  $coupon;
            $coupon->fill($data);
            $coupon->save();
            if($request->hasFile('thumb_img')){
                $current_images=$coupon->images;
                if($current_images)
                Storage::disk('public')->delete([$current_images->thumb_img]);
                $coupon->images()->delete();

                $originalImage=$request->file('thumb_img');
                $thumbImg       = ImageIntervetor::make($originalImage)->resize(50,50)->stream();
                $thumbImgPath   = 'images/coupons/thumb_img/';
                $thumb_img_name     = 'thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();

                $image  = new Image;
                $image->thumb_img   = $thumbImgPath.$thumb_img_name;
                Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);
                $coupon->images()->save($image);
             }
             return redirect()->route('coupons.index')->with('success','Updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon,Request $request)
    {
        if($request->ajax()){
            $validator=Validator::make($request->all(),[
                'statsid' => 'required|exists:coupons,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $coupon=$coupon;
                $current_images=$coupon->images;
               if($current_images)
               Storage::disk('public')->delete([$current_images->thumb_img]);
               $coupon->images()->delete();
               $coupon->delete();
               return response()->json(['status' => 'success']);
            }

        }
    }
}
