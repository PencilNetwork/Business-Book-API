<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\OfferResource;
use App\Http\Resources\BussinesResource;
use App\Offer;
use App\Bussines;
class OfferController extends Controller
{

    public function index(Request $request){
        return  OfferResource::collection(Offer::where('bussines_id',$request->bussines_id)->get()); 
    }
    public function create(){
        return view('offer.create'); 
    }
    public function show(Offer $offer){
        $offer= new OfferResource($offer);
        if($offer){
            return $offer;
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
            'caption' => 'required',
            'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'bussines_id' => 'required|max:255',
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


    public function update(Offer $offer ,Request $request){
        $validator = \Validator::make($request->all(), [
            // 'caption' => 'required',
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg',
            // 'bussines_id' => 'required',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $inputs = $request->all();
        if($request->image){
            $imageName = time().'.'.request()->image->getClientOriginalName();
            request()->image->move(public_path('images'), $imageName);
            $inputs['image']  = $imageName ; 
        } 
        if($offer->update($inputs)){
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

    public function  destroy(Offer $offer){
        if($offer->delete()){
            return response()->json(['flag'=>'1'],201);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }


    
}
