<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Storage;
use Intervention\Image\Facades\Image as ImageIntervetor;
use Yajra\DataTables\Facades\DataTables;

class PlansController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if($request->ajax()){
          $plans=Plan::get();
          return Datatables::of($plans)
                ->addIndexColumn()
                ->editColumn('title', function($plans){
                    return isset($plans->title)? $plans->title :'-' ;
                })
                ->addColumn('allowable_days',function($plans){
                    return isset($plans->allowable_days)? $plans->allowable_days :'Nil' ;
                })
                ->addColumn('price',function($plans){
                    return isset($plans->price)? $plans->price :'Nil' ;
                })
                ->addColumn('action',function($plans){
                    $actionBtn = '<a href="'.route('plans.edit',['plan'=>$plans->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
      }
      return view('admin.plans.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.plans._create');
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'title'=>'required|string|unique:plans,title,'.$id,
            'allowable_days'=>'nullable|integer|min:1',
            'price'=>'required|regex:/^\d+(\.\d{1,2})?$/',
            'img' =>'nullable|mimes:jpeg,png,jpg,svg',
        ];
        $validator=Validator::make($request->all(),$rules,[
            'title.required' => 'Title is required.',
            'title.unique' => 'This Plan already exists.',
            'allowable_days.integer'=>'Mismatch in no.of allowed days.',
            'allowable_days.min'=>'Mismatch in no.of allowed days.',
            'price.required' => 'Price is required.'
        ]);
        return $validator;
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
        }else{
            $data           = $request->all();
        $plan           = new Plan;
        $plan->fill($data);
        $plan->save();
        if($request->hasFile('img')){
            $originalImage=$request->file('img');
            $thumbImg      = ImageIntervetor::make($originalImage)->resize(50,50)->stream();
            $thumbImgPath   = 'images/plans/';
            $thumb_img_name     = 'plans'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();

           $image  = new Image;
           $image->thumb_img   = $thumbImgPath.$thumb_img_name;
           Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);

          $plan->images()->save($image);

        }
        return redirect()->route('plans.index')->with('success','Plan created successfully!');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function show(Plan $plan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        $data=[];
        $data['plandata']=$plan; $data['enbldEdit']=true;
        return view('admin.plans._create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $validator=$this->checkValidation($request,$plan->id);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $plan =  $plan;
            $plan->fill($data);
            $plan->save();
            if($request->hasFile('img')){
                $current_images=$plan->images;
                if($current_images)
                Storage::disk('public')->delete([$current_images->thumb_img]);
                $plan->images()->delete();

                $originalImage=$request->file('img');
                $thumbImg       = ImageIntervetor::make($originalImage)->resize(50,50)->stream();
                $thumbImgPath   = 'images/plans/';
                $thumb_img_name     = 'plans'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();
                $image  = new Image;
                $image->thumb_img   = $thumbImgPath.$thumb_img_name;
                Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);
                $plan->images()->save($image);
             }
            return redirect()->route('plans.index')->with('success','Plan updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Plan $plan)
    {
        //
    }
}
