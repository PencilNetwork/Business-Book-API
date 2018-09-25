<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource; 
use App\Http\Resources\ProvinceResource; 
use App\Http\Resources\RegoinResource; 
use App\Category; 
use App\Province; 
use App\Regoin; 
class CategoryController extends Controller
{
    // dispaly all cats 
    public function index (){
   

        return CategoryResource::collection(Category::all())  ;
    }
    public function index1 (){
   

        return CategoryResource::collection(Category::all())  ;
    }
    // return all provinces
    public function provinces(){
        return json_encode(ProvinceResource::collection(Province::all()) ,JSON_UNESCAPED_UNICODE) ;
    }
    // return all regoins for one  province
    public function regoins (Request $request,$province_id ){
        $validator = \Validator::make($request->all(), [
            'province_id' => 'required',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        return json_encode(RegoinResource::collection(Regoin::where('province_id',$province_id)->get()) ,JSON_UNESCAPED_UNICODE) ;
    }
}
