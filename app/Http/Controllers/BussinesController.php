<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bussines; 
use App\Http\Resources\BussinesResource; 
use Illuminate\Support\Facades\DB; 
class BussinesController extends Controller
{
    
    public function create(){
        return view('bussines.create');
    }
    public function test(){
        return BussinesResource::collection(Bussines::paginate()); 
    }
      
    //show, edit 
    public function show (Request $request , $bussines ){
        $req =$request->all();
        $req['bussines']= \Route::current()->parameter('bussines');

        $validator = \Validator::make($req, [
            'bussines' => 'required|exists:bussines,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        $bussines= new BussinesResource(Bussines::findOrFail($bussines));
        if($bussines){
            return $bussines;
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }

    public function edit (Bussines $bussines){
        

       
        if($bussines){
            return view('bussines.edit',compact("bussines")); 
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }
    
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'contact_number' => 'required|numeric',
            'city_id' => 'required|numeric|exists:cities,id',
            'regoin_id' => 'nullable',
            'address' => 'required',
            'langitude' => 'required',
            'lattitude' => 'required',
            'category_id' => 'required|numeric|exists:categories,id',
            'owner_id' => 'required|exists:owners,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        // move image 
        $image = time().'.'.request()->image->getClientOriginalName();
        request()->image->move(public_path('images'), $image);
        $bussines = $request->all();
        $bussines['image']  = $image ; 
        
        // move logo 
        if($request->logo){
            $logo = time().'.'.request()->logo->getClientOriginalName();
            request()->logo->move(public_path('images'), $logo);
            $bussines['logo']  = $logo ;
        }
         
        if($b = Bussines::create($bussines)){
            $response = [
                'flag'=>1,
                'data'=>  new BussinesResource($b )
            ];
        }else {
            return response()->json([ 'flage'=>'0']);
        
        }
        return response()->json($response,201); 
        
    }

    // public function edit(Request $request, $id ){
    //     $bussines = DB::table('bussines')->where('id',$id)->first();
    // }

    public function update(Bussines $bussines ,Request $request){
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
            'image' =>'required|image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'contact_number' => 'required|numeric',
            'city_id' => 'required|numeric|exists:cities,id',
            'regoin_id' => 'nullable|exists:regoins,id|numeric',
            'address' => 'required',
            'langitude' => 'required',
            'lattitude' => 'required',
            'category_id' => 'required|numeric',
            'owner_id' => 'required|exists:owners,id|numeric',
        ]);
        $inputs = $request->all();
        
        if($request->image){
            $imageName = time().'.'.request()->image->getClientOriginalName();
            request()->image->move(public_path('images'), $imageName);
            $inputs['image']  = $imageName ; 
        }
        if($request->logo){
            $imageName = time().'.'.request()->logo->getClientOriginalName();
            request()->logo->move(public_path('images'), $imageName);
            $inputs['logo']  = $imageName ; 
        }
        if($bussines->update($inputs)){
            return response()->json(['flag'=>'1'] , 201);
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }
    // public function  destroy(Bussines $bussines){
    //     $bussines->destroy(); 
    // }
    

}
