<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Bussines; 
class Owner extends Model
{
    protected $table = 'owners';
    protected $guarded = [];
    public function  bussines(){
    	return $this->hasMany('App\Bussines','owner_id','id'); 
    }
    
}
