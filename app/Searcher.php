<?php

namespace App;
use App\Interest; 
use Illuminate\Database\Eloquent\Model;

class Searcher extends Model
{
    //
    protected $guarded = [];
    public function favoirtes()
    {
        return $this->hasMany("App\Favoirte","searcher_id","id");
    }
    public function interest()
    {
        return $this->hasOne('App\Interest');
    }
    public function ratings (){
        return $this->hasMany("App\Rating","searcher_id","id"); 
    }
}
