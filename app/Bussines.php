<?php

namespace App;
use App\Category; 
use App\Offer; 
use App\File; 
use App\Rating; 
use App\owner; 
use Illuminate\Database\Eloquent\Model;

class Bussines extends Model
{
    //
    protected $table = "bussines"; 
    
    protected $guarded = [];
    public function owner(){
        return $this->belongsTo('App\Owner','owner_id','id'); 
    }
    public function category()
    {
        return $this->belongsTo("App\Category",'category_id','id');
    }

    public function offers()
    {
        return $this->hasMany("App\Offer",'bussines_id','id');
    }

    public function files()
    {
        return $this->hasMany("App\File",'bussines_id','id');
    }

    public function ratings()
    {
        return $this->hasMany("App\Rating",'bussines_id','id');
    }

    
    public function averageRating(){
        $ratings = $this->ratings;

        if (!$ratings->isEmpty()) {
            $sum = 0;

            foreach ($ratings as $rating) {
                $sum += $rating->rating;
            }

            return $sum / $ratings->count();
        }
        return 0 ; 
    }
    



}
