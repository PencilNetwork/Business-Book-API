<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    //
    protected $guarded = [];
    public $timestamps = false;
    public function bussines()
    {
        return $this->belongsTo("App\Bussines","bussines_id","id");
    }
    public function searcher()
    {
        return $this->belongsTo("App\Searcher","searcher_id",'id');
    }
}
