<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //
    protected $table = 'provinces';
    protected $guarded = [];

    public function regoins()
    {
        return $this->hasMany("App\Regoin","province_id","id");
    }
}
