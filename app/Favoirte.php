<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favoirte extends Model
{
    protected $guarded = [];
    public $timestamps = false;

    public function searcher()
    {
        return $this->belongsTo("App\Searcher","searcher_id","id");
    }
    
    // get some bussines details(logo,bussins_name) whene dislplay favoirtes for one searcher 
    public function get_bussines($bussines_id){
        $bussines = Bussines::where('id',$bussines_id)->first(['name','logo']);
        $bussines->logo="https://pencilnetwork.com/bussines_book/public/images/".$bussines->logo;
        return $bussines;
    }

}
