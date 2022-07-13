<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Validator;

use Yajra\DataTables\DataTables;

class PromoCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $promo = PromoCode::get();

            return Datatables::of($promo)
                ->addIndexColumn()
                ->editColumn('code_name', function($promo){
                    return isset($promo->code_name)? $promo->code_name :'-' ;
                })
                ->addColumn('code',function($promo){
                    return isset($promo->code)? $promo->code:'-' ;
                })
                ->addColumn('validity',function($promo){
                    return ($promo->validity) ? 'YES' : 'NO';
                })

                ->editColumn('reusable',function($promo){
                    return ($promo->reusable == 1) ? 'YES' : 'NO';
                })
                ->addColumn('action',function($promo){
                    $actionBtn = '<a href="'.route('promocode.edit',['promocode'=>$promo->id]).'" class="edit btn-sm"><i class="fa fa-edit"></i></a><a href="javascript:void(0)" data-sid="'.$promo->id.'" class="delete btn btn-danger btn-sm newtrash"><i class="fa fa-trash"></i></a>';
                    return $actionBtn;
                })

                ->rawColumns(['action'])

                ->make(true);
        }
        return view('admin.promocode.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $data['plan']=Plan::get();
        return view('admin.promocode._create',compact(['data']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      //  dd($request->all());
        $validator=$this->checkValidation($request);

        if($validator->fails()){
         //dd($validator);

            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
         
           if(!isset($data['reusable'])){
              $data['count_usage']=1;
           }
          
        $promo = new PromoCode();
        $promo->fill($data);
        $promo->save();


        return redirect()->route('promocode.index')->with('success','Promocode created successfully!');
        }
    }

    protected function checkValidation(Request $request,$id=null){
        $rules=array();
        $rules=[
            'code_name'=>'required|string',
            'discount_percentage'=>'required',
            'plan_id'=>'required',
            'prefix'=>'required',
            'code'=>'required|unique:promo_codes,code,'.$id

        ];

        $validator=Validator::make($request->all(),$rules,[
            'code_name.required' => 'Title is required.',
            'plan_id.required'=>'Plan is required.',
            'discount_percentage.required'=>'Percentage of discount is required.',
            'prefix.required'=>'Prefix is required.',
            'code.required'=>'Code is required',
            'code.unique'=>'Code must be unique'
        ]);
        return $validator;
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
        //
        $data=[];
        $data['plan']=Plan::get();
        $data['promo']=PromoCode::find($id); $data['enbldEdit']=true;
       // dd($data);
        return view('admin.promocode._create',compact(['data']));
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
        //
        $validator=$this->checkValidation($request,$id);
        if($validator->fails()){
          //  dd($validator);
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $data   = $request->all();
            if(!isset($data['reusable'])){
                $data['count_usage']=1;
             }
            $promo = PromoCode::find($id);
            $promo->fill($data);
            $promo->save();

             return redirect()->route('promocode.index')->with('success','Updated successfully!');

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        if ($request->ajax()) {
            $validator=Validator::make($request->all(),[
                'statsid' => 'required|exists:promo_codes,id',
            ],[ ]);
            if($validator->fails()){
                return response()->json(['status'=>'invalid']);
            }else{
                $promo_data=PromoCode::find($id);
               $promo_data->delete();
               return response()->json(['status' => 'success']);
            }
        }
    }
}
