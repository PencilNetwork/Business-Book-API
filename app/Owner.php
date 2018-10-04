<?php

namespace App;
use App\Owner; 
use Illuminate\Database\Eloquent\Model;
class Owner extends Model
{
    protected $table = 'owners';
    protected $guarded = [];
    public function  bussines(){
    	return $this->hasMany('App\Bussines','owner_id','id'); 
    }
    
}
