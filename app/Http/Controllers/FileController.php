<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\File;
use App\Http\Resources\FileResource; 

class FileController extends Controller
{
    public function create( ){
        return view('files.create');
    }   
     
    // update  one  related file 
    public function update(Request $request){
        
        $req =$request->all();
        $req['file']= \Route::current()->parameter('file');
        // dd($req['file']);
        $validator = \Validator::make($req, [
            'file' => 'required|exists:files,id|numeric',
            'image'=> 'required',
            'image.*' =>'image|mimes:jpeg,png,jpg,gif,svg',
            // 'bussines_id' => 'required',
        ]);
        
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        
        // dd("ok");
        if($request->image){
            $imageName = time().'.'.request()->image->getClientOriginalName();
            request()->image->move(public_path('images'), $imageName);
        } 

        if( File::where('id' , $req['file'] )->update(['image'=>$imageName])) {
            return response()->json( [ 'flag'=>'1']);
        }else{
            return response()->json( [ 'flag'=>'0']);
        } 
        
    }
    
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'bussines_id' => 'required|exists:bussines,id|numeric',
            'image' =>'required',
            'image.*' =>'image|mimes:jpeg,png,jpg,gif,svg',
        ]);

        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }

        $inputs = $request->all();

        // dd($request->all()); 
        foreach( $request->file('image') as $img)
        {
           $imageName = time().'.'.$img->getClientOriginalName();
           $img->move(public_path('images'), $imageName); 

            $inputs['image'] = $imageName;
            File::create($inputs);
        }
        return response()->json(['flag'=>'1']);

        
    }
    
    public function  destroy(Request $request){
        $req =$request->all();
        $req['file']= \Route::current()->parameter('file');
        // dd($req['file']);
        $validator = \Validator::make($req, [
            'file' => 'required|exists:files,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        if(File::where('id',$req['file'])->delete()){
            return response()->json(['flag'=>'1'],201);
        }else{
            return response()->json(['flag'=>'0'],400);
        }
    }
    
    public function test_delete (File $file){
        if($file){
            return view('files.delete',compact("file")); 
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }
    public function edit (File $file){
        if($file){
            return view('files.edit',compact("file")); 
        }else {
            return response()->json(['flag'=>'0'],400);
        }
    }
}
