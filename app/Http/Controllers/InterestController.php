<?php

namespace App\Http\Controllers;
use App\Http\Resources\InterestResource;
use App\Interest;
use Illuminate\Http\Request;
use App\Searcher; 

class InterestController extends Controller
{
    
    public function create(){
        return view('interests.create'); 
    }

    
    public function store(Request $request){
        $validator = \Validator::make($request->all(), [
            'searcher_id' => 'required|unique:interests|numeric',
            'categories_ids' =>'required', // many  cats  
            'city_id' => 'required|numeric', // one city 
            'regoins_ids' => 'required',// many regoins 
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        if(Interest::create($request->all())){
            return response()->json(['flag'=>'1']);
        }else{
            return response()->json(['flag'=>'0']);
        }
    }

    public function show (Request $request){
        $req =$request->all();
        $req['searcher']= \Route::current()->parameter('searcher'); // searcher_id 
        $validator = \Validator::make($req, [
            'searcher' => 'required|exists:searchers,id|numeric',
        ]);
        
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
    
        if($interest = Interest::where('searcher_id' , $req['searcher'])->first() ) {
            // dd($interest); 

            return  new InterestResource($interest);
        }else {
            return response()->json(['flag','0'],400);
        }
        
    }
 
    public function update_test(Interest $interest){
        return view('interests.edit',compact('interest'));
    }
    
    public function update (Request $request){
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');
        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|numeric',
        ]);
        
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        
        if(Interest::where('searcher_id' , $req['searcher_id'])->update( $request->only(['categories_ids','city_id','regoins_ids'])) ){
            return response()->json( [ 'flag'=>'1']);
        }else{
            return response()->json( [ 'flag'=>'0']);
        } 
    }
}
