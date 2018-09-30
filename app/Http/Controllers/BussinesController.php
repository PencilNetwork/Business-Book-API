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
    //show, edit 
    public function show (Bussines $bussines){
        $bussines= json_encode(new BussinesResource($bussines), JSON_UNESCAPED_UNICODE);
        // $bussines= new BussinesResource($bussines);
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
            'description' => 'required|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'contact_number' => 'required',
            'city_id' => 'required',
            // 'regoin_id' => 'required',
            'address' => 'required',
            'langitude' => 'required',
            'lattitude' => 'required',
            'category_id' => 'required',
            'owner_id' => 'required',
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
                'data'=> json_encode( new BussinesResource($b ), JSON_UNESCAPED_UNICODE)
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
            'image' =>'image|mimes:jpeg,png,jpg,gif,svg',
            'description' => 'required|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            'contact_number' => 'required',
            'city_id' => 'required',
            // 'regoin_id' => 'required',
            'address' => 'required',
            'langitude' => 'required',
            'lattitude' => 'required',
            'category_id' => 'required',
            'owner_id' => 'required',
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
    public function  destroy(Bussines $bussines){
        $bussines->destroy(); 
    }
    

}
