<?php

namespace App;
use App\Provine; 
use App\Bussines; 
use Illuminate\Database\Eloquent\Model;

class Regoin extends Model
{
    //
    protected $table = 'regoins';
    protected $guarded = [];
    public function city()
    {
        return $this->belongsTo("App\City","city_id","id");
    }

    public function bussines()
    {
        return $this->hasMany("App\Bussines","regoin_id","id");
    }
}
