<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource; 
 
use App\Category; 
class CategoryController extends Controller
{
    // dispaly all cats 
    public function index (){
        return CategoryResource::collection(Category::all());
    } 
}
