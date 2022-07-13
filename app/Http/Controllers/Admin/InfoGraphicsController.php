<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\InfoGraphic;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as ImageIntervetor;

class InfoGraphicsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $infoGraphics     = InfoGraphic::with('images')->get();
            return Datatables::of($infoGraphics)
            ->addIndexColumn()
             ->addColumn('img', function($infoGraphics){
                    return isset($infoGraphics->images->img)? asset('storage/'.$infoGraphics->images->img) :'-' ;
                })
                ->addColumn('alt_text', function($infoGraphics){
                    return isset($infoGraphics->alt_text)? $infoGraphics->alt_text :'-' ;
                })
                ->addColumn('action',function($infoGraphics){
                    $actionBtn = '<a href="'.route('infoGraphics.edit',['infoGraphic'=>$infoGraphics->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$infoGraphics->id.'" class="delete btn btn-danger btn-sm newtrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }

        return view('admin.infographics.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.infographics._create');
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'alt_text'=>'required|string|unique:info_graphics,alt_text,'.$id,
            'width'=>'nullable|integer|min:0|max:1200',
            'height'=>'nullable|integer|min:0|max:750',
        ];
        if(isset($id) && ($bg_img=InfoGraphic::find($id)->images)){
            $rules['img']='nullable|mimes:jpeg,png,jpg,svg';
        }else{
            $rules['img']='required|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'alt_text.required' => 'Alt text is required.',
            'img.required' => 'Image is required.',
            'width.integer' => 'Width value should be number and maximum 1200px.',
            'height.integer'=>'Height value should be number and maximum 750px.',
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
        }
        else{
            $data   = $request->all();
        $infogr = new InfoGraphic;
        $infogr->fill($data);
        $infogr->save();
        $img            = $request->file('img');
        $imgPath        = 'images/infographics/';
        $img_name       = 'infographics'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();
        $thumbImgPath   = 'images/infographics/';
        $thumb_img_name     = 'infographics_thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();
        $image  = new Image;
        $image->img   = $imgPath.$img_name;
        $image->thumb_img   = $thumbImgPath.$thumb_img_name;
        $height=$request->input('width'); $width=$request->input('height');
        if(is_numeric($height) && $height > 0 && is_numeric($width) &&  $width > 0){
            $final_img= ImageIntervetor::make($img)->resize($height,$width)->stream();
            Storage::disk('public')->put($imgPath.$img_name, $final_img);
        }else{
            $final_img=$img;
            $final_img->storeAs($imgPath, $img_name, 'public');
        }
        $thumbImg  = ImageIntervetor::make($img)->resize(70,70)->stream();
        Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);
        $infogr->images()->save($image);
        return redirect()->route('infoGraphics.index')->with('success','Infographics created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $infoGraphic=InfoGraphic::find($id);
        $data['infodata']=$infoGraphic;
        $data['enbldEdit']=true;

        return view('admin.infographics._create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $infoGraphic=InfoGraphic::find($id);
        $validator=$this->checkValidation($request,$id);
         if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
         }else{
            $data   = $request->all();
            $data['alt_text'] = $request->alt_text;
            $infoGraphic->fill($data);
            $infoGraphic->save();
            if($request->hasFile('img')){
               // $originalImage=$request->file('bg_img');
               $current_images=$infoGraphic->images;
               if($current_images){
                    Storage::disk('public')->delete([$current_images->img]);
                    Storage::disk('public')->delete([$current_images->thumb_img]);
               }
               $infoGraphic->images()->delete();
               $img            = $request->file('img');
               $imgPath        = 'images/infographics/';
               $img_name       = 'infographics'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();
               $thumbImgPath   = 'images/infographics/';
               $thumb_img_name     = 'infographics_thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();
               $image  = new Image;
               $image->img   = $imgPath.$img_name;
               $image->thumb_img   = $thumbImgPath.$thumb_img_name;
               $height=$request->input('width'); $width=$request->input('height');
              if(is_numeric($height) && $height > 0 && is_numeric($width) &&  $width > 0){
                    $final_img= ImageIntervetor::make($img)->resize($height,$width)->stream();
                    Storage::disk('public')->put($imgPath.$img_name, $final_img);
              }
              else{
                    $final_img=$img;
                    $final_img->storeAs($imgPath, $img_name, 'public');
              }
                $thumbImg  = ImageIntervetor::make($img)->resize(70,70)->stream();
                Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);
               $infoGraphic->images()->save($image);
           }
           return redirect()->route('infoGraphics.index')->with('success','Updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
      * @param  \App\Models\InfoGraphic  $info
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        //
        if ($request->ajax()) {

            $re=$request->all();
            $id=$re['statsid'];
            $validator=Validator::make($request->all(),[
                'statsid' => 'required|exists:info_graphics,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $news_data=InfoGraphic::find($id);
                $current_images=$news_data->images;
               if($current_images)
               Storage::disk('public')->delete([$current_images->img]);
               $news_data->images()->delete();
               $news_data->delete();
               return response()->json(['status' => 'success']);
            }
        }

    }
}
