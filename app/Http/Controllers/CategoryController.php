<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource; 
use Illuminate\Support\Facades\DB; 
use App\Category; 
class CategoryController extends Controller
{
    // dispaly all cats 
    public function index (){
        return CategoryResource::collection(Category::all());
    } 
    public function insert_categories(){
     
        $data = file_get_contents(base_path('resources/categories'));
        // dd($data) ; 
        foreach (explode("\n", $data) as $key=>$line ) {
            DB::table('categories')->insert(['name' => $line]);
             
        }
        dd("inseted categories ok ");
        
    }
}
