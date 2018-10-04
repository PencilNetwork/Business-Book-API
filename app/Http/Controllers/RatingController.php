<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rating;
use App\Bussines ; 

class RatingController extends Controller
{
   
    public function store_test (){
        return view('ratings.store'); 
    }
    

    public function store_or_update(Request $request){
        $validator = \Validator::make($request->all(), [
            'bussines_id' => 'required',
            'searcher_id' => 'required',
            'rating'      =>'required',
            
        ]);
        if( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $rating = Rating::where('bussines_id',$request->bussines_id)->where('searcher_id',$request->searcher_id)->first(); 
        // dd($rating); 
        if($rating == null ){
            Rating::create($request->all()); 
            return response()->json(['flag'=>'1'], 201 );
        }else{
            $rating->update(["rating"=>$request->rating]);
            return response()->json(['flag'=>'1'], 201 );
        }
        return response()->json( [ 'flag'=> '0' ,'errors' => 'can not update rating ' ], 400 );
    }
    // public function bussines_rating(Bussines $bussines){
    //     $averageRating=$bussines->averageRating();
    //     dd($averageRating); 

    // }

}
