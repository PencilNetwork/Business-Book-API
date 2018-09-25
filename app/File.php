<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    //
    protected $guarded = [];
    public function bussines()
    {
        return $this->belongsTo("App\Bussines","bussines_id","id");
    }
}
