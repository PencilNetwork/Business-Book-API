<?php

namespace App;
use App\Provine; 
use Illuminate\Database\Eloquent\Model;

class Regoin extends Model
{
    //
    protected $table = 'regoins';
    protected $guarded = [];
    public function provine()
    {
        return $this->belongsTo("App\Provine","province_id","id");
    }

}
