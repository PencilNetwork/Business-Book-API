<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Http\Resources\CityResource; 

use App\City;

class CityController extends Controller
{
    // return all provinces
    public function cities(){
        // return CityResource::collection(City::all()) ;
        return CityResource::collection(City::all());
    }

    
}
