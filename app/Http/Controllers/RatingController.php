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
    public function update_test (Rating $rating){
        return view('ratings.update',['rating'=>$rating]); 
    }
    public function store(Request $request){
        $validator = \Validator::make($request->all(), [
            'bussines_id' => 'required',
            'searcher_id' => 'required',
            'rating' =>'required',
            
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        // check if searcher make rating for this bussine 
        $rating= Rating::where([['bussines_id',$request->bussines_id],['searcher_id',$request->searcher_id]])->first(); 
        if(!$rating){
            try{
                if(Rating::create($request->all())){
                    return response()->json(['flag'=>'1'], 201 );
                }else{
                    return response()->json( [ 'flag'=> '0' ,'errors' => 'can not create rating ' ], 400 );
                }
            }catch(Exception $e){
                dd("error"); 
            }
            

        }else {
            return response()->json(['flag'=>'0','errors'=>'rating already exists'], 201 );
        }
        
    }

    public function update(Rating $rating,Request $request){
        $validator = \Validator::make($request->all(), [
            'bussines_id' => 'required',
            'searcher_id' => 'required',
            'rating' =>'required',
            
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        if( $rating->update(["rating"=>$request->rating]) ){
            return response()->json(['flag'=>'1'], 201 );
        }else{
            return response()->json( [ 'flag'=> '0' ,'errors' => 'can not update rating ' ], 400 );
        }
    }
    // public function bussines_rating(Bussines $bussines){
    //     $averageRating=$bussines->averageRating();
    //     dd($averageRating); 

    // }

}
