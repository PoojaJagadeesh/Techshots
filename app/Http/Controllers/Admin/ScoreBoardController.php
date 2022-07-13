<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Image;
use App\Models\ScoreBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Storage;
use Illuminate\Support\Facades\Validator;

class ScoreBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $scoreboard = ScoreBoard::with(['images'])->get();
            return Datatables::of($scoreboard)
                ->addIndexColumn()
                ->addColumn('bg_img',function($scoreboard){
                    return isset($scoreboard['images']['img']) ? asset('storage/'.$scoreboard['images']['img']) : '-';
                })
                ->editColumn('alt_text', function($scoreboard){
                    return isset($scoreboard->alt_text)? $scoreboard->alt_text :'-' ;
                })
                ->addColumn('action',function($scoreboard){
                    $actionBtn = '<a href="'.route('scoreBoard.edit',['scoreBoard'=>$scoreboard->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$scoreboard->id.'" class="delete btn btn-danger btn-sm newtrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.scoreboard.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scoreboard._create');
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
            $validator=$this->checkValidation($request);
            $data   = $request->all();
            $news = new ScoreBoard;
            $news->fill($data);
            $news->save();

            $img            = $request->img;
            $imgPath        = 'images/scoreboard/';
            $img_name       = 'scorboard'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

            $image  = new Image;
            $image->img   = $imgPath.$img_name;

            $img->storeAs($imgPath, $img_name, 'public');

            $news->images()->save($image);
            return redirect()->route('scoreBoard.index')->with('success','Scoreboard created successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function show(ScoreBoard $scoreBoard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function edit(ScoreBoard $scoreBoard)
    {
        $data['scoredata']=$scoreBoard;
        $data['enbldEdit']=true;
        return view('admin.scoreboard._create',compact('data'));
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'alt_text'=>'required|string|unique:score_boards,alt_text,'.$id,
        ];
        if(isset($id) && ($bg_img=ScoreBoard::find($id)->images)){
            $rules['img']='nullable|mimes:jpeg,png,jpg,svg';
        }else{
            $rules['img']='required|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'alt_text.required' => 'Alt text is required.',
            'img.required'=>'Background image is required.',
        ]);
        return $validator;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ScoreBoard $scoreBoard)
    {
        $validator=$this->checkValidation($request,$scoreBoard->id);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            $scoreBoard = $scoreBoard;
            $scoreBoard->fill($data);
            $scoreBoard->save();
            if($request->hasFile('img')){
                $current_images=$scoreBoard->images;
                if($current_images)
                Storage::disk('public')->delete([$current_images->img]);
                $scoreBoard->images()->delete();

                $img=$request->file('img');
                $imgPath        = 'images/scoreboard/';
                $img_name       = 'scorboard'.Str::random(4).Carbon::now()->timestamp.'.'.$img->extension();

                $image  = new Image;
                $image->img   = $imgPath.$img_name;
                $img->storeAs($imgPath, $img_name, 'public');
                $scoreBoard->images()->save($image);
             }
             return redirect()->route('scoreBoard.index')->with('success','Updated successfully!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ScoreBoard  $scoreBoard
     * @return \Illuminate\Http\Response
     */
    public function destroy(ScoreBoard $scoreBoard,Request $request)
    {
        if ($request->ajax()) {
            $validator=Validator::make($request->all(),[
                'statsid' => 'required|exists:score_boards,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $scoreBoard_data=$scoreBoard;
                $current_images=$scoreBoard_data->images;
               if($current_images)
               Storage::disk('public')->delete([$current_images->img]);
               $scoreBoard_data->images()->delete();
               $scoreBoard_data->delete();
               return response()->json(['status' => 'success']);
            }
        }
    }
}
