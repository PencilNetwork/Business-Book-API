<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\RegoinResource;
use App\Regoin; 
class RegoinController extends Controller
{
    // return all regoins for one  city
    public function regoins (Request $request,$city_id ){
        $req =$request->all();
        $req['city_id']= \Route::current()->parameter('city_id');
        $validator = \Validator::make($req, [
            'city_id' => 'required|exists:cities,id|numeric',
        ]);
        if ( $validator->fails() ) {
            return response()->json( [ 'flag'=>'0' ,'errors' => $validator->errors() ], 400 );
        }
        return RegoinResource::collection(Regoin::where('city_id',$city_id)->get()) ;
    }
}
