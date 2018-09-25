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
            return  FavoirteResource::collection($favoirtes);
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

    public function delete(Favoirte $favoirte){
        if($favoirte->delete()){
            return response()->json(['flag'=>'1'],201);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }

    
}
