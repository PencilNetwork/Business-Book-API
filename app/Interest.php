<?php

namespace App;
use App\Searcher; 
use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    //
    protected $guarded = [];
    public function searcher()
    {
        return $this->belongsTo(Searcher::class);
    }

}
