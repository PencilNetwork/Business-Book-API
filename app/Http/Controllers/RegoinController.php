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
        // $validator = \Validator::make($request->all(), [
        //     'city_id' => 'required',
        // ]);
        // if ( $validator->fails() ) {
        //     return response()->json( [ 'flage'=>'0' ,'errors' => $validator->errors() ], 400 );
        // }
        return json_encode(RegoinResource::collection(Regoin::where('city_id',$city_id)->get()) ,JSON_UNESCAPED_UNICODE) ;
    }
}
