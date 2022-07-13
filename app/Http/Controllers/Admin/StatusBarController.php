<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Image;
use App\Models\StatusBar;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Intervention\Image\Facades\Image as ImageIntervetor;
use Yajra\DataTables\Facades\DataTables;


class StatusBarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $statusBars = StatusBar::with(['images'])->get();
            return Datatables::of($statusBars)
                ->addIndexColumn()
                ->editColumn('heading', function($statusBars){
                    return isset($statusBars->heading)? $statusBars->heading :'-' ;
                })
                ->editColumn('year', function($statusBars){
                    return isset($statusBars->year)? $statusBars->year :'-' ;
                })
                ->addColumn('display_year',function($statusBars){
                    return isset($statusBars->display_date)? Carbon::createFromFormat('Y-m-d', $statusBars->display_date)->format('F, d, Y') :'-' ;
                })
                ->addColumn('thumb_img',function($statusBars){
                    return isset($statusBars['images']['thumb_img']) ? asset('storage/'.$statusBars['images']['thumb_img']) : '-';
                })
                ->addColumn('action',function($statusBars){
                    $actionBtn = '<a href="'.route('statusBar.edit',['statusBar'=>$statusBars->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$statusBars->id.'" class="delete btn btn-danger btn-sm statrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.status-bar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.status-bar._create');
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
            $year   = new Carbon($request->year);
            $data['year'] = $year->year;
            $status = new StatusBar;
            $status->fill($data);
            $status->save();

            $originalImage=$request->file('bg_img');
            $bgImg          = $originalImage;
            $thumbImg       = ImageIntervetor::make($originalImage)->resize(70,70)->stream();

            $thumbImgPath   = 'images/thumb_img/';
            $bgPath         = 'images/bg_img/';

            $thumb_img_name     = 'thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();
            $bg_img_name        = 'bg'.Str::random(4).Carbon::now()->timestamp.'.'.$bgImg->extension();

            $image  = new Image;
            $image->thumb_img   = $thumbImgPath.$thumb_img_name;
            $image->bg_img      = $bgPath.$bg_img_name;

            $bgImg->storeAs($bgPath, $bg_img_name, 'public');
            Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);

            $status->images()->save($image);
            return redirect()->route('statusBar.index')->with('success','Status created successfully!');
        }

    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'heading'=>'required|string|unique:status_bars,heading,'.$id,
            'content'=>'required|string',
            'year'=>'required|date_format:Y-m-d',
            'display_date'=>'required|date_format:Y-m-d',
        ];
        if(isset($id) && ($bg_img=StatusBar::find($id)->images)){
            $rules['bg_img']='nullable|mimes:jpeg,png,jpg,svg';
        }else{
            $rules['bg_img']='required|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'heading.required' => 'Heading is required.',
            'content.required'=>'Content is required.',
            'bg_img.required'=>'Background image is required.',
        ]);
        return $validator;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StatusBar  $statusBar
     * @return \Illuminate\Http\Response
     */
    public function show(StatusBar $statusBar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\StatusBar  $statusBar
     * @return \Illuminate\Http\Response
     */
    public function edit(StatusBar $statusBar)
    {
        $data=[];
        $data['statdata']=$statusBar; $data['enbldEdit']=true;
        return view('admin.status-bar._create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StatusBar  $statusBar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StatusBar $statusBar)
    {
        $validator=$this->checkValidation($request,$statusBar->id);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $year   = new Carbon($request->year);
            $data['year'] = $year->year;
            $status = $statusBar;
            $status->fill($data);
            $status->save();
            if($request->hasFile('bg_img')){
               $current_images=$status->images;
               if($current_images)
               Storage::disk('public')->delete([$current_images->thumb_img,$current_images->bg_img]);
               $status->images()->delete();

               $originalImage=$request->file('bg_img');
               $bgImg          = $originalImage;
               $thumbImg       = ImageIntervetor::make($originalImage)->resize(70,70)->stream();

               $thumbImgPath   = 'images/thumb_img/';
               $bgPath         = 'images/bg_img/';

            $thumb_img_name     = 'thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();
            $bg_img_name        = 'bg'.Str::random(4).Carbon::now()->timestamp.'.'.$bgImg->extension();

            $image  = new Image;
            $image->thumb_img   = $thumbImgPath.$thumb_img_name;
            $image->bg_img      = $bgPath.$bg_img_name;

            $bgImg->storeAs($bgPath, $bg_img_name, 'public');
            Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);

            $status->images()->save($image);
            }
            return redirect()->route('statusBar.index')->with('success','Updated successfully!');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StatusBar  $statusBar
     * @return \Illuminate\Http\Response
     */
    public function destroy(StatusBar $statusBar,Request $request)
    {
        if ($request->ajax()) {
            $validator=Validator::make($request->all(),[
                'statsid' => 'required|exists:status_bars,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $status=$statusBar;
                $current_images=$status->images;
               if($current_images)
               Storage::disk('public')->delete([$current_images->thumb_img,$current_images->bg_img]);
               $status->images()->delete();
               $status->delete();
               return response()->json(['status' => 'success']);
            }
        }

    }
}
