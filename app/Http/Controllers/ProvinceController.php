<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use App\Province;

class ProvinceController extends Controller
{
    
    public function insert_province(){
        // Read File
        $jsonString = file_get_contents(base_path('resources/province.json'));

        $data = json_decode($jsonString, true);
        foreach ($data as $province) {
            DB::table('provinces')->insert(['Place_Id' => $province['Place_Id'], 'Place_Name' => $province['Place_Name']]);
            // Province::create([ ['Place_Id'=> $province['Place_Id']] , ['Place_Name'=> $province['Place_Name']] ]); 
        }
        dd('inserted successfully'); 

    }
    
}
