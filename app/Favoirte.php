<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favoirte extends Model
{
    protected $guarded = [];
    public function searcher()
    {
        return $this->belongsTo("App\Searcher","searcher_id","id");
    }

}
