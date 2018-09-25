<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\SearcherResource; 
use App\Http\Resources\BussinesResource; 
use App\Http\Resources\OfferResource; 
use Illuminate\Support\Facades\DB;
use App\Interest; 
use App\Searcher; 
use App\Bussines;
use App\Offer; 
class SearcherController extends Controller
{
    //
    public function login(Request $request){
        // dd($request->all()); 
        $request->validate([
            'social_id' => 'required',
        ]);
        $searcher= DB::table('searchers')->where('social_id',$request->social_id)->first(); 
        if($searcher){
            return new SearcherResource($searcher) ; 
        }else{
            $validator = \Validator::make($request->all(), [
                'name' => 'required',
                'social_id' => 'required|unique:searchers',
                'email' => 'unique:searchers',
                'token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
            }

           if( $searcher =Searcher::create($request->all())){
                return new SearcherResource($searcher) ; 
           }else {
                return response()->json([ 'flag'=>'0'], 400 );
           }
            
        }
    }

    public function default_bussines_search(Request $request , $searcher_id){
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            $regoins = explode(',',$interest[0]->regoins);
            $categories = explode(',',$interest[0]->categories);
            $city = $interest[0]->city; 
            $bussines = Bussines::where('city',$city)->
                whereIn('category_id',$categories)->
                whereIn('regoin',$regoins)->get();
            
            return json_encode(  BussinesResource::collection($bussines),JSON_UNESCAPED_UNICODE); 
            
        }else {
            return response()->json(['flga'=>'0']);
        }
    }
    

    public function test_bussines_search(){
        return view('searcher.search');
    }
    // search by(name,province, regoins , category)
    public function search_bussines(Request $request){
        //only bussiness name  
        if($request->bussines_name && !$request->category_id && !$request->province_name && !$request->regoin_name){
            $bussines = Bussines::where('name','like','%'.$request->bussines_name.'%')->get();
            // dd($bussines); 
            return json_encode(BussinesResource::collection($bussines), JSON_UNESCAPED_UNICODE);
        }// only category
        elseif($request->category_id && !$request->bussines_name && !$request->province_name && !$request->regoin_name){
            $bussines = Bussines::where('category_id',$request->category_id)->get();
            // dd($bussines); 
            return json_encode(BussinesResource::collection($bussines), JSON_UNESCAPED_UNICODE);
        }
        // all fields
        elseif($request->province_name && $request->category_id && $request->regoin_name && $request->bussines_name){
            $bussines = Bussines::where('city',$request->province_name)->Where('regoin',$request->regoin_name)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->name.'%')->get();
            // dd($bussines); 
            return json_encode(BussinesResource::collection($bussines), JSON_UNESCAPED_UNICODE);
        }
        //province_name and on of(category_id,regoin_name,bussines_name)
        elseif($request->province_name && ($request->category_id || $request->regoin_name || $request->bussines_name)){
            $bussines = Bussines::where('city',$request->province_name)->orWhere('category_id',$request->category_id)->orWhere('name','like','%'.$request->name.'%')->get();
            // dd($bussines); 
            return json_encode(BussinesResource::collection($bussines), JSON_UNESCAPED_UNICODE);
        }
        else {
            return response()->json(['flag'=>'0'],400);
        }

    }
    public function search_by_name (){
        return view('searcher.search_by_name');
    }
    // search by bussines_name  dependant intersets 
    public function bussines_name(Request $request ){
        $validator = \Validator::make($request->all(), [
            'searcher_id' => 'required',
            'bussines_name' =>'required',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $searcher_id    = $request->searcher_id;
        $bussines_name  = $request->bussines_name; 
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            
            $city = $interest[0]->city; 
            // dd($city); 
            $bussines = Bussines::where([['city',$city],['name','like','%'.$bussines_name.'%']])->orWhere('name','like','%'.$bussines_name.'%')->get();
            
            return BussinesResource::collection($bussines); 
            
        }else {
            return response()->json(['flga'=>'0']);
        }
          
    }

    public function search_by_category (){
        return view('searcher.search_by_category');
    }
    // search by category  dependant intersets (short cuts)
    public function category(Request $request ){
        $validator = \Validator::make($request->all(), [
            'searcher_id' => 'required',
            'category_id' =>'required',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $searcher_id    = $request->searcher_id;
        $category_id  = $request->category_id; 
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            
            $city = $interest[0]->city; 
            // dd($city); 
            $bussines = Bussines::where([['city',$city],['category_id',$category_id]])->orWhere('category_id',$category_id)->get();
            
            return BussinesResource::collection($bussines); 
            
        }else {
            return response()->json(['flga'=>'0']);
        }
    }



    // offers methods 
    public function default_offer_search(Request $request , $searcher_id){
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            $regoins = explode(',',$interest[0]->regoins);
            $categories = explode(',',$interest[0]->categories);
            $city = $interest[0]->city; 
            $bussines = Bussines::where('city',$city)->
                whereIn('category_id',$categories)->
                whereIn('regoin',$regoins)->get(['id'])->toArray();
                
            $offers = Offer::whereIn('id',$bussines)->get(); 
            return json_encode( OfferResource::collection($offers), JSON_UNESCAPED_UNICODE); 
        }else {
            return response()->json(['flga'=>'0']);
        }
    }

    public function test_search_offer(){
        return view('offer.search');
    }
    // search by(name,province, regoins , category)
    public function search_offer(Request $request){
        //only bussiness name  
        if($request->bussines_name && !$request->category_id && !$request->province_name && !$request->regoin_name){
            
            $bussines = Bussines::where('name','like','%'.$request->bussines_name.'%')->get(['id']);
            
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return json_encode(OfferResource::collection($offers), JSON_UNESCAPED_UNICODE);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }// only category
        elseif($request->category_id && !$request->bussines_name && !$request->province_name && !$request->regoin_name){
            $bussines = Bussines::where('category_id',$request->category_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return json_encode(OfferResource::collection($offers), JSON_UNESCAPED_UNICODE);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
 
        }
        // all fields
        elseif($request->province_name && $request->category_id && $request->regoin_name && $request->bussines_name){
            // dd('all');
            $bussines = Bussines::where('city',$request->province_name)->Where('regoin',$request->regoin_name)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return json_encode(OfferResource::collection($offers), JSON_UNESCAPED_UNICODE);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }//province_name and on of(category_id,regoin_name,bussines_name)
        elseif( $request->province_name && ($request->category_id || $request->regoin_name || $request->bussines_name)){
            $bussines = Bussines::where('city',$request->province_name)->orWhere('category_id',$request->category_id)->orWhere('name','like','%'.$request->name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return json_encode(OfferResource::collection($offers), JSON_UNESCAPED_UNICODE);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }
        else {
            return response()->json(['flag'=>'0'],400);
        }

    }

}
