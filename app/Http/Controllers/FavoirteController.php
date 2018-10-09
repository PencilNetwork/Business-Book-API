<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Favoirte;
use App\Rating;
use App\Http\Resources\FavoirteResource;
class FavoirteController extends Controller
{
     
    public function index(Request $request, $searcher_id){
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');

        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $favoirtes =Favoirte::where('searcher_id',$searcher_id)->get(); 
        if($favoirtes){
            return FavoirteResource::collection($favoirtes);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }

    public function create(){
        return view('favoirte.create'); 
    }
    public function store(Request $request){
    	$validator = \Validator::make($request->all(), [
            'searcher_id' => 'required|exists:searchers,id|numeric',
            'bussines_id' => 'required|exists:bussines,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $favoirte =  Favoirte::firstOrCreate($request->only(['searcher_id','bussines_id'])); 
        if($favoirte){
            return response()->json(['flag'=>'1'],200);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }

    public function test_delete(){
        return view('favoirte.delete');
    }
    public function destroy(Request $request , $searcher_id, $bussines_id){
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');
        $req['bussines_id']= \Route::current()->parameter('bussines_id');
        
        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|numeric',
            'bussines_id' => 'required|exists:bussines,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        if(Favoirte::where('searcher_id',$searcher_id)->where('bussines_id',$bussines_id)->delete()){
            return response()->json(['flag'=>'1'],201);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }
    // check if this  bussines in  in favoirtes or not 
    public function check_bussines_favoirte(Request $request , $searcher_id, $bussines_id)
    {
        
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');
        $req['bussines_id']= \Route::current()->parameter('bussines_id');

        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|numeric',
            'bussines_id' => 'required|exists:bussines,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }

        $favoirte = Favoirte::where('searcher_id',$searcher_id)->where('bussines_id',$bussines_id)->first();
        $rate = Rating::where([['searcher_id',$searcher_id],['bussines_id',$bussines_id]])->first();
        
        if($favoirte){
            // retrive the rating which make it this user for  this bussines 
            // user may not make rate for this bussines
            if(!$rate){
                return response()->json(['flag'=>"0"]);
            }else {
                return response()->json(['flag' => "1" , 'rating'=>$rate->rating]);
            }
        }else {
            if(!$rate){
                return response()->json(['flag'=>"0"]);
            }else {
                return response()->json(['flag' => "0" , 'rating'=>$rate->rating]);
            } 
        }
    }
    
    
}