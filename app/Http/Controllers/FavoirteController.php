<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;
use App\Favoirte;
use App\Http\Resources\FavoirteResource;
class FavoirteController extends Controller
{
     
    public function index(Request $request, $searcher_id){
        $favoirtes =Favoirte::where('searcher_id',$searcher_id)->get(); 
        if($favoirtes){
            return response()->json(["data"=>json_encode(FavoirteResource::collection($favoirtes) ,JSON_UNESCAPED_UNICODE)] );
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }

    public function create(){
        return view('favoirte.create'); 
    }
    public function store(Request $request){
    	$validator = \Validator::make($request->all(), [
            'searcher_id' => 'required',
            'bussines_id' => 'required',
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

    public function destroy(Favoirte $favoirte){
        if($favoirte->delete()){
            return response()->json(['flag'=>'1'],201);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }
    public function check_bussines_favoirte(Request $request , $searcher_id, $bussines_id)
    {
        $favoirte = Favoirte::where('searcher_id',$searcher_id)->where('bussines_id',$bussines_id)->first();
        if($favoirte){
            return response()->json(['flag'=>"1"]);
        } else {
            return response()->json(['flag'=>"0"]);
        }
    }
    // return favoirtes for one searcher 
    // public function favoirtes(Request $request,){
    // }
    
}