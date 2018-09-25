<?php

namespace App\Http\Controllers;
use App\Http\Resources\InterestResource;
use App\Interest;
use Illuminate\Http\Request;
use App\Searcher; 

class InterestController extends Controller
{
    //
    public function create(){
        return view('interests.create'); 
    }

    
    public function store(Request $request){
        $validator = \Validator::make($request->all(), [
            'searcher_id' => 'required|unique:interests',
            'categories' =>'required',
            'city' => 'required',
            'regoins' => 'required',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        if(Interest::create($request->all())){
            return response()->json(['flag'=>'1']);
        }else{
            return response()->json(['flag'=>'0']);
        }
    }

    public function show (Request $request,Searcher $searcher){
        if($request->searcher && $interest = $searcher->interest){
                return json_encode( new InterestResource($interest),JSON_UNESCAPED_UNICODE);
        }else {
            return response()->json(['flag','0']);
        }
    }

    public function update_test(Interest $interest){
        return view('interests.edit',compact('interest'));
    }
    public function update (Request $request , Interest $interest){
        if($interest->update( $request->only(['categories','city','regoins'])) ){
            return response()->json( [ 'flag'=>'1']);
        }else{
            return response()->json( [ 'flag'=>'0']);
        } 
    }
}
