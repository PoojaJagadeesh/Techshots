<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Storage;
use Intervention\Image\Facades\Image as ImageIntervetor;
use Yajra\DataTables\Facades\DataTables;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       // $news     = News::paginate(10);
        if ($request->ajax()) {
            $news = News::with(['images'])->get();
            return Datatables::of($news)
                ->addIndexColumn()
                ->editColumn('heading', function($news){
                    return isset($news->heading)? $news->heading :'-' ;
                })
                ->addColumn('display_date',function($news){
                    return isset($news->display_date)? Carbon::createFromFormat('Y-m-d', $news->display_date)->format('F, d, Y') :'-' ;
                })
                ->addColumn('bg_img',function($news){
                    return isset($news['images']['img']) ? asset('storage/'.$news['images']['img']) : '-';
                })
                ->addColumn('action',function($news){
                    $actionBtn = '<a href="'.route('news.edit',['news'=>$news->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$news->id.'" class="delete btn btn-danger btn-sm newtrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->editColumn('is_premium',function($news){
                    return ($news->is_premium == 1) ? 'YES' : 'NO';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.news._create');
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
            $data['description'] = $data['description'] ? preg_replace( "/(\r|\n)/", "", $data['description']) : $data['description'];
        $news = new News;
        $news->fill($data);
        $news->save();

        $img            = $request->img;
        $imgPath        = 'images/news/';

        $img_name       = 'news'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

        $image  = new Image;
        $image->img   = $imgPath.$img_name;

        $img->storeAs($imgPath, $img_name, 'public');

        $news->images()->save($image);
        return redirect()->route('news.index')->with('success','News created successfully!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function show(News $news)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit(News $news)
    {
      $data=[];
        $data['newsdata']=$news; $data['enbldEdit']=true;
        return view('admin.news._create',compact('data'));
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'heading'=>'required|string|unique:news,heading,'.$id,
            'description'=>'required|string',
            'tag'=>'required|string',
            'display_date'=>'required|date_format:Y-m-d',
            'order_num'=>'nullable|integer|min:0',
        ];
        if(isset($id) && ($bg_img=News::find($id)->images)){
            $rules['img']='nullable|mimes:jpeg,png,jpg,svg';
        }else{
            $rules['img']='required|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'heading.required' => 'Heading is required.',
            'descriptiond'=>'Content is required.',
            'img.required'=>'Background image is required.',
        ]);
        return $validator;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $validator=$this->checkValidation($request,$news->id);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $data['is_premium'] = ($request->input('is_premium')) ? 1 : null;
            $data['description'] = $data['description'] ? preg_replace( "/(\r|\n)/", "", $data['description']) : $data['description'];
            $news = $news;
            $news->fill($data);
            $news->save();
            if($request->hasFile('img')){
                $current_images=$news->images;
                if($current_images)
                Storage::disk('public')->delete([$current_images->img]);
                $news->images()->delete();

                $img=$request->file('img');
                $imgPath        = 'images/news/';
                $img_name       = 'news'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

                $image  = new Image;
                $image->img   = $imgPath.$img_name;
                $img->storeAs($imgPath, $img_name, 'public');
                $news->images()->save($image);
             }
             return redirect()->route('news.index')->with('success','Updated successfully!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy(News $news,Request $request)
    {
        if ($request->ajax()) {
        $validator=Validator::make($request->all(),[
            'statsid' => 'required|exists:news,id',
        ],[ ]);
        if($validator->fails()){
            return response()->json(['status'=>'invalid']);
        }else{
            $news_data=$news;
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
