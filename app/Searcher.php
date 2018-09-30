<?php

namespace App;
use App\Interest; 
use Illuminate\Database\Eloquent\Model; 
class Searcher extends Model
{
    
    protected $guarded = [];
    public $timestamps = false;
    public function favoirtes()
    {
        return $this->hasMany("App\Favoirte","searcher_id","id");
    }
    public function test(){
        echo "asd"; 
    }

    public function interest($searcher_id)
    {  
        return $this->hasOne(Interest::class);  
    }


    // public function interest($searcher_id)
    // {  
    //     $interest = Interest::where('searcher_id',$searcher_id)->get(); 
    //     dd($interest); 
    //     // return $this->hasOne('App\Interest');
    // }

    public function ratings (){
        return $this->hasMany("App\Rating","searcher_id","id"); 
    }
}
