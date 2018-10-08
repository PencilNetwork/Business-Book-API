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
    public function test_update_token(){
        return view('searcher.update_token');
    }
    //update token if it updated  in  the same device 
    public function update_token(Request $request){
        $validator = \Validator::make($request->all(), [
            'searcher_id' => 'required|exists:searchers,id|integer',
            'new_token' => 'required',
            'old_token' => 'required',
        ]);
        $old = $request->old_token;
        $new = $request->new_token ; 
        if ($validator->fails()) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $searcher = Searcher::find($request->searcher_id);
        $tokens = explode(",",$searcher->token);
        if(in_array($old , $tokens) ){
            if (($key = array_search($old , $tokens )) !== false) {
                unset($tokens[$key]);
            }  
            array_push($tokens,$new);
            $tokens = implode(",", $tokens );
            Searcher::find($searcher->id)->update(['token'=>$tokens]);
            return response()->json( [ 'flag'=>'1' ],201 );
        }
        else {
            return response()->json( [ 'flag'=>'0' ,'errors' => "old token not exists" ], 400 );
        } 


    }
    public function login(Request $request){
         
        $validator = \Validator::make($request->all(), [
            'social_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        
        $searcher = DB::table('searchers')->where('social_id',$request->social_id)->first(); 
        //if already exists in db 
        if($searcher){
            if($request->token){
                // add new token if open form different device 
                $token = $request->token; 
                $tokens = explode(",",$searcher->token) ;
                if(!in_array($token, $tokens)){
                    array_push($tokens,$token); 
                    $tokens = implode(",", $tokens );
                    Searcher::find($searcher->id)->update(['token'=>$tokens]);
                    $searcher->token = $tokens; 
                }
            }
            return new SearcherResource($searcher) ;
        }else{  //if enter  for first time 
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

    public function default_bussines_search(Request $request , $searcher_id , $page_number){
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');
        $req['page_number']= \Route::current()->parameter('page_number');
        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|integer',
            'page_number' => 'required|integer',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }

        
        $offset = ($request->page_number-1)*10; 
        $perPage =10;
        $current_page = $request->page_number;


        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){

            $regoins_ids = explode(',',$interest[0]->regoins_ids);
            $categories_ids = explode(',',$interest[0]->categories_ids);
            $city_id = $interest[0]->city_id; 

            $total_result = Bussines::where('city_id',$city_id)->
            whereIn('category_id',$categories_ids)->
            whereIn('regoin_id',$regoins_ids)->count();

            $bussines = Bussines::where('city_id',$city_id)->
            whereIn('category_id',$categories_ids)->
            whereIn('regoin_id',$regoins_ids)->skip($offset)->take(10)->get();
            $total_pages = ceil( $total_result/10 );
            if($total_pages == 0 ){
                return OfferResource::collection($bussines);
            }
            if($current_page > $total_pages){
                return response()->json(['flag'=>'0','errors' => "current page not valid"],400);
            }
            $b = new \Illuminate\Pagination\LengthAwarePaginator(
                $bussines, 
                $total_pages, 
                $perPage, 
                $current_page
            );
            return BussinesResource::collection($b); 
            
        }else {
            return response()->json(['flga'=>'0']);
        }
    }
    

    public function test_bussines_search(){
        return view('searcher.search');
    }

    // search by(name,city, regoins , category)
    public function search_bussines(Request $request){
        // vlidation 
        $validator = \Validator::make($request->all(), [
            'bussines_name' => 'nullable',
            'category_id' => 'nullable|exists:categories,id|integer',
            'city_id' => 'nullable|exists:cities,id|integer',
            'regoin_id' => 'nullable|exists:regoins,id|integer',
            'page_number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $offset = ($request->page_number-1)*10; 
        $perPage =10;
        $current_page = $request->page_number;

        //only bussiness name  
        if($request->bussines_name && !$request->category_id && !$request->city_id && !$request->regoin_id){
            
            // count all result based on search constraint
            $total_result = Bussines::where('name','like','%'.$request->bussines_name.'%')->count();
            // take some results based on pagination (10 items for one request) 
            $bussines = Bussines::where('name','like','%'.$request->bussines_name.'%')->skip($offset)->take(10)->get();
            
        }// only category
        elseif($request->category_id && !$request->bussines_name && !$request->city_id && !$request->regoin_id){
            $total_result = Bussines::where('category_id',$request->category_id)->count();

            $bussines = Bussines::where('category_id',$request->category_id)->skip($offset)->take(10)->get();
            
        }
        // all fields
        elseif($request->city_id && $request->category_id && $request->regoin_id && $request->bussines_name){
            $total_result = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->count();
           
            $bussines     = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->skip($offset)->take(10)->get();
            
        }
        //city_id and category_id and  busssines name 
        elseif($request->city_id && $request->category_id && $request->bussines_name && !$request->regoin_id ){
            $total_result = Bussines::where('city_id',$request->city_id)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->count();
          
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->skip($offset)->take(10)->get();
            
        }
        //city_id and regoin_id category_id and  
        elseif($request->city_id && $request->category_id &&  $request->regoin_id && !$request->bussines_name ){
            $total_result = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id',$request->category_id)->count();
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id',$request->category_id)->skip($offset)->take(10)->get();
            
        }
        //city_id and category_id
        elseif($request->city_id && $request->category_id && !$request->regoin_id && !$request->bussines_name){
            $total_result = Bussines::where('city_id',$request->city_id)->Where('category_id',$request->category_id)->count();
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id',$request->category_id)->skip($offset)->take(10)->get();
           
            
        }//city_id and bussines_name
        elseif($request->city_id && $request->bussines_name && !$request->category_id && !$request->regoin_id ){
            $total_result = Bussines::where('city_id',$request->city_id)->Where('name','like','%'.$request->bussines_name.'%')->count();
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('name','like','%'.$request->bussines_name.'%')->skip($offset)->take(10)->get();
           
        }//city_id and regoin_id
        elseif($request->city_id && $request->regoin_id && !$request->bussines_name && !$request->category_id  ){
           
            $total_result = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->count();

            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->skip($offset)->take(10)->get();
           
        }
        //(category_id & bussines_name)
        elseif($request->category_id && $request->bussines_name && !$request->city_id && !$request->regoin_id ){
            $total_result = Bussines::Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->count();
            
            $bussines = Bussines::Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->skip($offset)->take(10)->get();
            
        }
        else {
            return response()->json(['flag'=>'0'],400);
        }
        
        // this code for  all previous cases 
        $total_pages=ceil( $total_result/10 );
        if($total_pages == 0 ){
            return BussinesResource::collection($bussines);
        }

        if($current_page > $total_pages){
            return response()->json(['flag'=>'0','errors' => "current page not valid"],400);
        }
        $b = new \Illuminate\Pagination\LengthAwarePaginator(
            $bussines, 
            $total_pages, 
            $perPage, 
            $current_page
        );
        
        return BussinesResource::collection($b);


    }
    public function search_by_name (){
        return view('searcher.search_by_name');
    }
    // search by bussines_name  dependant intersets 
    public function bussines_name(Request $request ){
        $validator = \Validator::make($request->all(), [
            'searcher_id' => 'required|exists:searchers,id|integer',
            'bussines_name' =>'required',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $searcher_id    = $request->searcher_id;
        $bussines_name  = $request->bussines_name; 
        $interest = Interest::where('searcher_id',$searcher_id)->paginate(10); 
        if(!$interest->isEmpty()){
            
            $city = $interest[0]->city_id; 
            
            $bussines = Bussines::where([['city_id',$city_id],['name','like','%'.$bussines_name.'%']])->orWhere('name','like','%'.$bussines_name.'%')->paginate(10);
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
            'searcher_id' => 'required|exists:searchers,id|integer',
            'category_id' =>'required|exists:categories,id|integer',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $searcher_id    = $request->searcher_id;
        $category_id  = $request->category_id; 
        $interest = Interest::where('searcher_id',$searcher_id)->paginate(10); 
        if(!$interest->isEmpty()){
            
            $city_id = $interest[0]->city_id; 
            $bussines = Bussines::where([['city_id',$city_id],['category_id',$category_id]])->orWhere('category_id',$category_id)->paginate(10);
            return BussinesResource::collection($bussines);
        }else {
            return response()->json(['flag'=>'0']);
        }
    }



    // offers methods 
    public function default_offer_search(Request $request , $searcher_id,$page_number){
        $req =$request->all();
        $req['searcher_id']= \Route::current()->parameter('searcher_id');
        $req['page_number']= \Route::current()->parameter('page_number');
        $validator = \Validator::make($req, [
            'searcher_id' => 'required|exists:searchers,id|integer',
            'page_number' => 'required|integer',

        ]);

        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }

        $offset = ($request->page_number-1)*10; 
        $perPage =10;
        $current_page = $request->page_number;

        
        $interest = Interest::where('searcher_id',$searcher_id)->get(); 
        if(!$interest->isEmpty()){
            $regoins_ids = explode(',',$interest[0]->regoins_ids);
            $categories_ids = explode(',',$interest[0]->categories_ids);
            $city_id = $interest[0]->city_id; 
            $ids = Bussines::where('city_id',$city_id)->
                whereIn('category_id',$categories_ids)->
                whereIn('regoin_id',$regoins_ids)->get(['id'])->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count(); 
            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 
             

            $total_pages = ceil( $total_result/10 );
            if($total_pages == 0 ){
                return OfferResource::collection($offers);
            }
            $f = new \Illuminate\Pagination\LengthAwarePaginator(
                $offers, 
                $total_pages, 
                $perPage, 
                $current_page
            );
            
            if($current_page > $total_pages){
                return response()->json(['flag'=>'0','errors' => "current page not valid"],400);
            }
            return OfferResource::collection($f); 

        }else {
            return response()->json(['flga'=>'0']);
        }
    }

    public function test_search_offer(){
        return view('offer.search');
    }


    // search by(name , city , regoins , category)
    public function search_offer(Request $request){

        // vlidation 
        $validator = \Validator::make($request->all(), [
            'bussines_name' => 'nullable',
            'category_id' => 'nullable|exists:categories,id|integer',
            'city_id' => 'nullable|exists:cities,id|integer',
            'regoin_id' => 'nullable|exists:regoins,id|integer',
            'page_number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $offset = ($request->page_number-1)*10; 
        $perPage =10;
        $current_page = $request->page_number;

        //only bussiness name  
        if($request->bussines_name && !$request->category_id && !$request->city_id && !$request->regoin_id){
            
            $bussines = Bussines::where('name','like','%'.$request->bussines_name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();
            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get();

        }// only category
        elseif($request->category_id && !$request->bussines_name && !$request->city_id && !$request->regoin_id){
            $bussines = Bussines::where('category_id',$request->category_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 

        }
        // all fields
        elseif($request->city_id && $request->category_id && $request->regoin_id && $request->bussines_name){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id',$request->regoin_id)->Where('category_id' , $request->category_id)->Where('name', 'like' ,'%'.$request->bussines_name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 
            
        } 
        //city_id and category_id and  busssines name 
        elseif($request->city_id && $request->category_id && $request->bussines_name && !$request->regoin_id ){
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id' , $request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 
 
        }
         //city_id and regoin_id and category_id 
         elseif( $request->city_id && $request->regoin_id  && $request->category_id  && !$request->bussines_name){
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id' , $request->regoin_id)->Where('category_id' , $request->category_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 

        }
        //city_id and category_id  
        elseif($request->city_id && $request->category_id && !$request->bussines_name && !$request->regoin_id ){
            
            $bussines = Bussines::where('city_id',$request->city_id)->Where('category_id' , $request->category_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 

        }
        //city_id  and  busssines name 
        elseif($request->city_id && $request->bussines_name  && !$request->category_id && !$request->regoin_id ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('name','like','%'.$request->bussines_name.'%')->get(['id']);
            $ids = $bussines->toArray();
            
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 
   
        }
        //city_id and regoin_id 
        elseif($request->city_id && $request->regoin_id && !$request->category_id && !$request->bussines_name  ){
            $bussines = Bussines::where('city_id',$request->city_id)->Where('regoin_id' , $request->regoin_id)->get(['id']);
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get(); 
  
        }
        //(category_id & bussines_name)
        elseif($request->category_id && $request->bussines_name && !$request->city_id && !$request->regoin_id ){
            $bussines = Bussines::Where('category_id',$request->category_id)->Where('name','like','%'.$request->bussines_name.'%')->get();
            
            $ids = $bussines->toArray();
            
            $total_result = Offer::whereIn('bussines_id',$ids)->count();

            $offers = Offer::whereIn('bussines_id',$ids)->orderBy('id', 'desc')->skip($offset)->take(10)->get();
 
        }
        else {
            return response()->json(['flag'=>'0'],400);
        }


        $total_pages=ceil($total_result/10);
        $page = $request->page_number;
        if($total_pages == 0 ){
            return OfferResource::collection($offers);
        }
        $f = new \Illuminate\Pagination\LengthAwarePaginator(
            $offers, 
            $total_pages, 
            $perPage, 
            $current_page
        );

        if($current_page > $total_pages){
            return response()->json(['flag'=>'0','errors' => "current page not valid"],400);
        }

        if($f){
            return OfferResource::collection($f);
        }else {
           return response()->json(['flag'=>'0'],400); 
        }

    }

}
