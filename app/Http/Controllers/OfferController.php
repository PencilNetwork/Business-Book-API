<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OfferResource;
use App\Http\Resources\BussinesResource;
use App\Offer;
use App\Bussines;
class OfferController extends Controller
{
    /*not used*/
    public function index(Request $request,$bussines_id){
        $request['bussines_id']= \Route::current()->parameter('bussines_id');
        $validator = \Validator::make($request->all(), [
            'bussines_id' => 'required|exists:bussines,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        return OfferResource::collection(Offer::where('bussines_id',$request->bussines_id)->get()) ;
    }

    public function create(){
        return view('offer.create'); 
    }

    // show one offer details 
    /*not used*/
    public function show(Request $request,$bussines_id){

        $request['offer']= \Route::current()->parameter('offer');
        $validator = \Validator::make($request->all(), [
            'offer' => 'required|exists:offers,id|numeric',
        ]);
        
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        
        if($offer = Offer::where('id',$request['offer'])->first()){
            return new OfferResource($offer);
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }

    public function edit(Offer $offer){
        if($offer){
            return view('offer.edit' , compact("offer")); 
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }
    
    
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            // 'caption' => 'required',
            'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'bussines_id' => 'required|exists:bussines,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        
        $imageName = time().'.'.request()->image->getClientOriginalName();
        request()->image->move(public_path('images'), $imageName);
        $inputs = $request->all();
        $inputs['image']  = $imageName ; 
        
        if(Offer::create($inputs)){
            return response()->json(['flag'=>'1'],201);
        }else {
            return response()->json(['flag'=>'0','errors'=>'can not create offer'],400);

        }

        // return new BussinesResource($bussines);
    }


    public function update(Request $request, $offer ){
        $request['offer']= \Route::current()->parameter('offer');
        $validator = \Validator::make($request->all(), [
            'offer' => 'required|exists:offers,id|numeric',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg',
        ]);
        
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
    
        $inputs = $request->only(['caption']);
        
        if($offer = Offer::where('id',$offer)->first()){
            if($request->image){
                // delete old img 
                $path = public_path('/images/'.$offer->image); 
                if(file_exists($path)){
                    @unlink($path);
                }
                $imageName = time().'.'.request()->image->getClientOriginalName();
                request()->image->move(public_path('images'), $imageName);
                $inputs['image']  = $imageName ; 
            } 
            Offer::find($offer->id)->update($inputs); 
            return response()->json( [ 'flag'=>'1']);
        }else{
            return response()->json( [ 'flag'=>'0']);
        } 
    }
    public function test_delete (Offer $offer){
        if($offer){
            // dd($offer);
            return view('offer.delete', compact("offer") ); 
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }

    public function  destroy( Request $request,$offer ){
        $req['offer']= \Route::current()->parameter('offer');
        $validator = \Validator::make($req, [
            'offer' => 'required|exists:offers,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $offer =Offer::where('id' , $req['offer'])->first(); 
        if($offer){
            // delete old img 
            $path = public_path('/images/'.$offer->image); 
            if(file_exists($path)){
                @unlink($path);
            } 
            Offer::destroy($offer->id);
            return response()->json(['flag'=>'1'],201);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }


    
}
