<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class RegoinController extends Controller
{
    // insert province's regoins 
    


    // public function insert_regoins(){

    //     // Read File

    //     $jsonString = file_get_contents(base_path('resources/regoins/tanta.json'));

    //     $data = json_decode($jsonString, true);
    //     // dd($data); 

    //     foreach ($data as $regoin) {
    //         DB::table('regoins')->insert(['Place_Id' => $regoin['Place_Id'], 'Place_Name' => $regoin['Place_Name'], 'province_id' => 596]);
    //     }
    //     dd('inserted successfully'); 

    // }
}
