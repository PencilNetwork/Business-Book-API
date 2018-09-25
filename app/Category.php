<?php

namespace App;
use App\Bussines;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $guarded = [];
    public function bussines()
    {
        return $this->hasMany("App\Bussines","category_id","id");
    }
}
