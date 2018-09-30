<?php

namespace App;

use Illuminate\Database\Eloquent\Model; 
class City extends Model
{
    //
    protected $table = 'cities';
    protected $guarded = [];

    public function regoins()
    {
        return $this->hasMany("App\Regoin","city_id","id");
    }

    public function bussines()
    {
        return $this->hasMany("App\Bussines","city_id","id");
    }
}
