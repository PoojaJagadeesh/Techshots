<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Discover as RequestsDiscover;
use Carbon\Carbon;
use App\Models\Image;
use App\Models\Discover;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Yajra\DataTables\Facades\DataTables;


class DiscoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $discover=Discover::with(['images'])->get();
            return Datatables::of($discover)
                ->addIndexColumn()
                ->editColumn('heading', function($discover){
                    return isset($discover->heading)? $discover->heading :'-' ;
                })
                ->addColumn('tag',function($discover){
                    return isset($discover->tag)? $discover->tag :'-' ;
                })
                ->addColumn('link_url',function($discover){
                    return isset($discover->link)? $discover->link :'-' ;
                })
                ->addColumn('img',function($discover){
                    return isset($discover['images']['img']) ? asset('storage/'.$discover['images']['img']) : '-';
                })
                ->addColumn('action',function($discover){
                    $actionBtn = '<a href="'.route('discover.edit',['discover'=>$discover->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$discover->id.'" class="delete btn btn-danger btn-sm statrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('admin.discover.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discover._create');
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'heading'=>'required|string|unique:discovers,heading,'.$id,
            'link'=>'required|regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/',
            'tag'=>'required|string',
        ];
        if(isset($id) && ($bg_img=Discover::find($id)->images)){
            $rules['img']='nullable|mimes:jpeg,png,jpg,svg';
        }else{
            $rules['img']='required|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'heading.required' => 'Heading is required.',
            'link.regex' => 'Please provide the the proper url.',
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
        $discover           = new Discover;
        $discover->fill($data);
        $discover->save();
        $img            = $request->file('img');
        $imgPath        = 'images/discover/';
        $img_name       = 'discover'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

        $image  = new Image;
        $image->img   = $imgPath.$img_name;

        $img->storeAs($imgPath, $img_name, 'public');
        $discover->images()->save($image);
        return redirect()->route('discover.index')->with('success','Discover created successfully!');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discover  $discover
     * @return \Illuminate\Http\Response
     */
    public function show(Discover $discover)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discover  $discover
     * @return \Illuminate\Http\Response
     */
    public function edit(Discover $discover)
    {
        $data=[];
        $data['discoverdata']=$discover; $data['enbldEdit']=true;
        return view('admin.discover._create',compact('data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discover  $discover
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discover $discover)
    {
        $validator=$this->checkValidation($request,$discover->id);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $discover =  $discover;
            $discover->fill($data);
            $discover->save();
            if($request->hasFile('img')){
                $current_images=$discover->images;
                if($current_images)
                Storage::disk('public')->delete([$current_images->img]);
                $discover->images()->delete();

                $img=$request->file('img');
                $imgPath        = 'images/discover/';
                $img_name       = 'discover'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

                $image  = new Image;
                $image->img   = $imgPath.$img_name;
                $img->storeAs($imgPath, $img_name, 'public');
                $discover->images()->save($image);
             }
             return redirect()->route('discover.index')->with('success','Updated successfully!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discover  $discover
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discover $discover,Request $request)
    {
     if($request->ajax()){
        $validator=Validator::make($request->all(),[
            'statsid' => 'required|exists:discovers,id',
        ],[ ]);
        if($validator->fails()){
            return response()->json(['status'=>'invalid']);
        }else{
            $discover=$discover;
            $current_images=$discover->images;
           if($current_images)
           Storage::disk('public')->delete([$current_images->img]);
           $discover->images()->delete();
           $discover->delete();
           return response()->json(['status' => 'success']);
        }

     }
    }
}
