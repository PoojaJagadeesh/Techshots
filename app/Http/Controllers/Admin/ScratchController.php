<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scratch_card;
use App\Models\Scratch_offer;
use App\Models\Scratch_coin;
use App\Models\Image;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Storage;
use Intervention\Image\Facades\Image as ImageIntervetor;
use Yajra\DataTables\Facades\DataTables;
use DB;
use Illuminate\Validation\Rule;

class ScratchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $scratch_card=Scratch_card::with(['scratchable'])->get();
            return Datatables::of($scratch_card)
                ->addIndexColumn()
                ->editColumn('scratch_title', function($scratch_card){
                    return isset($scratch_card->scratch_title)? $scratch_card->scratch_title :'-' ;
                })
                ->addColumn('scratch_type',function($scratch_card){
                    $type='-';
                    if($scratch_card->scratchable_type === Scratch_offer::class){
                        $type='Offer';
                    }else if($scratch_card->scratchable_type === Scratch_coin::class){
                        $type='Coin';
                    }
                    return $type;
                })
                ->addColumn('action',function($scratch_card){
                    $actionBtn = '<a href="'.route('scratchCard.edit',['scratchCard'=>$scratch_card->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$scratch_card->id.'" class="delete btn btn-danger btn-sm statrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);

        }
        return view('admin.scratches.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.scratches._create');
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
            $data   = $request->all(); $entity='';
            $scratch_type  = (int)$request->input('scratch_type');
            DB::beginTransaction();
            try{
                switch($scratch_type){
                 case 0:  // 0 stands for offer
                    $entity  =  $this->generateScratchOffer($request);
                    break;
                 case 1: // 1 stands for coin
                    $entity  =  $this->generateScratchCoin($request);
                    break;
                }

                $scratch_card  = new Scratch_card;
                $scratch_card->description   = $data['description'];
                $scratch_card->scratch_title   = $data['scratch_title'];
                $entity->scratch_cards()->save($scratch_card);
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                dd($e->getMessage());
            }
            return redirect()->route('scratchCard.index')->with('success','Status created successfully!');
        }
    }

    public function generateScratchOffer(Request $request){
        $offer_data=new Scratch_offer;
        $offer_data->title  =  $request->input('offer_title');
        $offer_data->code   =  $request->input('offer_code');
        $offer_data->validity   =  $request->input('validity');
        $offer_data->save();
        if($request->hasFile('thumb_img')){
            $originalImage=$request->file('thumb_img');
            $thumbImg       = ImageIntervetor::make($originalImage)->resize(50,50)->stream();
            $thumbImgPath   = 'images/scratch_offer/thumb_img/';
            $thumb_img_name     = 'thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();
            $image  = new Image;
            $image->thumb_img   = $thumbImgPath.$thumb_img_name;
            Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);

            $offer_data->images()->save($image);
        }

     return $offer_data;
    }

    public function generateScratchCoin(Request $request){
        $coin_data=new Scratch_coin;
        $coin_data->equivalent_coins=$request->input('equivalent_coins');
        $coin_data->save();
     return $coin_data;
    }


    public function updateScratchOffer(Request $request,$id=null){
        $offer_data=Scratch_offer::find($id);
        $offer_data->title  =  $request->input('offer_title');
        $offer_data->code   =  $request->input('offer_code');
        $offer_data->validity   =  $request->input('validity');
        $offer_data->save();

        if($request->hasFile('thumb_img')){
            $current_images=$offer_data->images;
            if($current_images)
            Storage::disk('public')->delete([$current_images->thumb_img]);
            $offer_data->images()->delete();

            $originalImage=$request->file('thumb_img');
            $thumbImg       = ImageIntervetor::make($originalImage)->resize(50,50)->stream();
            $thumbImgPath   = 'images/scratch_offer/thumb_img/';
            $thumb_img_name     = 'thumb'.Str::random(4).Carbon::now()->timestamp.'.'.$originalImage->extension();
            $image  = new Image;
            $image->thumb_img   = $thumbImgPath.$thumb_img_name;
            Storage::disk('public')->put($thumbImgPath.$thumb_img_name, $thumbImg);
            $offer_data->images()->save($image);
         }
         return $offer_data;
    }

    public function updateScratchCoin(Request $request,$id=null){
        $coin_data=Scratch_coin::find($id);
        $coin_data->equivalent_coins=$request->input('equivalent_coins');
        $coin_data->save();
     return $coin_data;

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

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'scratch_title'=>'required|string',
            'scratch_type' =>'required|in:0,1',
            'offer_title' => 'required_if:scratch_type,==,0|nullable|string',
            'offer_code' => 'required_if:scratch_type,==,0|nullable|string',
            'validity'=>'required_if:scratch_type,==,0|nullable|date_format:Y-m-d',
            'equivalent_coins'=>'required_if:scratch_type,==,1|nullable|integer|min:1',
        ];
        if(isset($id)){
            $rec=Scratch_card::with('scratchable')->find($id);
            switch(true){
                case(($request->input('scratch_type') === "0" && !isset($rec->scratchable->images->thumb_img))):
                    $rules['thumb_img']=  'required|mimes:jpeg,png,jpg,svg';
                    break;
                default:
                    $rules['thumb_img']=  'nullable|mimes:jpeg,png,jpg,svg';
                    break;
            }

        }else{
            $rules['thumb_img']=  'required_if:scratch_type,==,0|mimes:jpeg,png,jpg,svg';
        }
        $validator=Validator::make($request->all(),$rules,[
            'scratch_title.required_if' => 'Title is required.',
            'thumb_img.required_if'=>'Thumb image is required.',
            'equivalent_coins.required_if'=>'Invalid number of coins'
        ]);
        return $validator;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($scratchCard)
    {
       $data=[];
       $scratch=Scratch_card::with('scratchable')->find((int)$scratchCard);
        $data['scratchdata']=$scratch; $data['enbldEdit']=true;
         if($scratch->scratchable_type === Scratch_offer::class){
             $scratch_type=  "0"; //stands for scratch offer
             $scratch_offer_img=  $scratch->scratchable->images->thumb_img ?? null;
         }else if($scratch->scratchable_type === Scratch_coin::class){
            $scratch_type= "1"; //stands for scratch coin
            $scratch_offer_img= null;
         }
         $data['scratchdata']['scratch_type']=  $scratch_type;
         $data['scratchdata']['scratch_offer_image']=  $scratch_offer_img;
        return view('admin.scratches._create',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $scratchCard)
    {
        $validator=$this->checkValidation($request,$scratchCard);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all(); $entity='';
            $scratch_type  = (int)$request->input('scratch_type');
            $scrcard=(int)$scratchCard;
            DB::beginTransaction();
            try{
                $scratch_card  = Scratch_card::with('scratchable')->find($scrcard);
                $scratch_card->description=  $data['description'];
                $scratch_card->scratch_title=  $data['scratch_title'];
                $currently_selected_scratchtype=  ($scratch_type == 0) ? Scratch_offer::class : ($scratch_type == 1 ? Scratch_coin::class : null);
                $current_scratchtype=  $scratch_card['scratchable_type'];
                $current_scratchtype_ID=  $scratch_card['scratchable']['id'] ?? null;

                switch(true){
                 case (($scratch_type == 0) && ($current_scratchtype === $currently_selected_scratchtype)):  // no changes
                    $entity  =  $this->updateScratchOffer($request,$current_scratchtype_ID);
                    break;
                 case (($scratch_type == 0) && ($current_scratchtype !== $currently_selected_scratchtype)): // changes from coin to offer
                    $entity  =  $this->generateScratchOffer($request);
                    break;
                case (($scratch_type == 1) && ($current_scratchtype === $currently_selected_scratchtype)):  // no changes
                    $entity  =  $this->updateScratchCoin($request,$current_scratchtype_ID);
                    break;
                case (($scratch_type == 1) && ($current_scratchtype !== $currently_selected_scratchtype)): // changes from offer to coin
                    $entity  =  $this->generateScratchCoin($request);
                     break;
                }
                $entity->scratch_cards()->save($scratch_card);
                DB::commit();
            }catch(\Exception $e){
                DB::rollback();
                dd($e->getMessage());
            }
            return redirect()->route('scratchCard.index')->with('success','Updated successfully!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
