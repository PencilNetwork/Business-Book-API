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
    
    public function login(Request $request){
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
                'email' => 'unique:searchers|email',
                'token' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
            }
            if( $searcher =Searcher::create($request->all())){
                return new SearcherResource($searcher); 
            }else{
                    return response()->json([ 'flag'=>'0'], 400 );
            }
        }
    }

    public function default_bussines_search(Request $request , $searcher_id){
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');
        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            $regoins_ids = explode(',',$interest[0]->regoins_ids);
            $categories_ids = explode(',',$interest[0]->categories_ids);
            $city_id = $interest[0]->city_id; 
            $bussines = Bussines::where('city_id',$city_id)->
                whereIn('category_id',$categories_ids)->
                whereIn('regoin_id',$regoins_ids)->get();
            
            return  BussinesResource::collection($bussines); 
            
        }else {
            return response()->json(['flga'=>'0']);
        }
    }
    

    public function test_bussines_search(){
        return view('searcher.search');
    }
    // search by(name,city, regoins , category)
    public function search_bussines(Request $request){
        //only bussiness name  
        if($request->bussines_name && !$request->category_id && !$request->city_id && !$request->regoin_id){
            $bussines = Bussines::where('name','like','%'.$request->bussines_name.'%')->get();
            return BussinesResource::collection($bussines);
        }// only category
        elseif($request->category_id && !$request->bussines_name && !$request->city_id && !$request->regoin_id){
            $bussines = Bussines::where('category_id',$request->category_id)->get();
            // dd($bussines); 
            return BussinesResource::collection($bussines);
        }
        // all fields
        elseif($request->city_id && $request->category_id && $request->regoin_id && $request->bussines_name){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->get();
            return BussinesResource::collection($bussines) ;
        }
        //city_id and category_id and  busssines name 
        elseif($request->city_id && $request->category_id && $request->bussines_name && !$request->regoin_id ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->get();
            return BussinesResource::collection($bussines);
        }
        //city_id and regoin_id category_id and  
        elseif($request->city_id && $request->category_id &&  $request->regoin_id && !$request->bussines_name ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id',$request->category_id)->get();
            return BussinesResource::collection($bussines);
        }
        //city_id and category_id
        elseif($request->city_id && $request->category_id && !$request->regoin_id && !$request->bussines_name){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id',$request->category_id)->get();
            return BussinesResource::collection($bussines);
        }//city_id and bussines_name
        elseif($request->city_id && $request->bussines_name && !$request->category_id && !$request->regoin_id ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('name','like','%'.$request->bussines_name.'%')->get();
            return BussinesResource::collection($bussines);
        }//city_id and regoin_id
        elseif($request->city_id && $request->regoin_id && !$request->bussines_name && !$request->category_id  ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->get();
            return BussinesResource::collection($bussines);
        }
        //(category_id & bussines_name)
        elseif($request->category_id && $request->bussines_name && !$request->city_id && !$request->regoin_id ){
            $bussines = Bussines::Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->get();
            return BussinesResource::collection($bussines);
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
            
            $city = $interest[0]->city_id; 
            // dd($city); 
            $bussines = Bussines::where([['city_id',$city_id],['name','like','%'.$bussines_name.'%']])->orWhere('name','like','%'.$bussines_name.'%')->get();
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
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $searcher_id    = $request->searcher_id;
        $category_id  = $request->category_id; 
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            
            $city_id = $interest[0]->city_id; 
            $bussines = Bussines::where([['city_id',$city_id],['category_id',$category_id]])->orWhere('category_id',$category_id)->get();
            return BussinesResource::collection($bussines);
            
        }else {
            return response()->json(['flag'=>'0']);
        }
    }



    // offers methods 
    public function default_offer_search(Request $request , $searcher_id){
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');
        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            $regoins_ids = explode(',',$interest[0]->regoins_ids);
            $categories_ids = explode(',',$interest[0]->categories_ids);
            $city_id = $interest[0]->city_id; 
            $bussines = Bussines::where('city_id',$city_id)->
                whereIn('category_id',$categories_ids)->
                whereIn('regoin_id',$regoins_ids)->get(['id'])->toArray();
            
            $offers = Offer::whereIn('bussines_id',$bussines)->get(); 
            return  OfferResource::collection($offers); 
        }else {
            return response()->json(['flga'=>'0']);
        }
    }

    public function test_search_offer(){
        return view('offer.search');
    }
    // search by(name , city , regoins , category)
    public function search_offer(Request $request){

        //only bussiness name  
        if($request->bussines_name && !$request->category_id && !$request->city_id && !$request->regoin_id){
            
            $bussines = Bussines::where('name','like','%'.$request->bussines_name.'%')->get(['id']);
            
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }// only category
        elseif($request->category_id && !$request->bussines_name && !$request->city_id && !$request->regoin_id){
            $bussines = Bussines::where('category_id',$request->category_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
 
        }
        // all fields
        elseif($request->city_id && $request->category_id && $request->regoin_id && $request->bussines_name){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id' , $request->category_id)->Where('name', 'like' ,'%'.$request->bussines_name.'%')->get(['id']);
            $ids = $bussines->toArray();
            // dd($ids); 
            // dd($request->all()); 
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        } 
        //city_id and category_id and  busssines name 
        elseif($request->city_id && $request->category_id && $request->bussines_name && !$request->regoin_id ){
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id' , $request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }
         //city_id and regoin_id and category_id 
         elseif( $request->city_id && $request->regoin_id  && $request->category_id  && !$request->bussines_name){
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id' , $request->regoin_id)->Where('category_id' , $request->category_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }
        //city_id and category_id  
        elseif($request->city_id && $request->category_id && !$request->bussines_name && !$request->regoin_id ){
            // dd('all');
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id' , $request->category_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }
        //city_id  and  busssines name 
        elseif($request->city_id && $request->bussines_name  && !$request->category_id && !$request->regoin_id ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('name','like','%'.$request->bussines_name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }
        //city_id and regoin_id 
        elseif($request->city_id && $request->regoin_id && !$request->category_id && !$request->bussines_name  ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id' , $request->regoin_id)->get(['id']);
            $ids = $bussines->toArray();
            // dd($ids); 
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }
        //(category_id & bussines_name)
        elseif($request->category_id && $request->bussines_name && !$request->city_id && !$request->regoin_id ){
            $bussines = Bussines::Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->get();
            
            $ids = $bussines->toArray();
            
            $offers = Offer::whereIn('bussines_id',$ids)->get(); 

            if($offers){
                return OfferResource::collection($offers);
            }else {
               return response()->json(['flag'=>'0'],400); 
            }
        }
        else {
            return response()->json(['flag'=>'0'],400);
        }

    }

}
