<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class InterestResource extends Resource
{
   
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'searcher_id' => $this->searcher_id,
            'categories' => $this->categories,
            'city' => $this->city,
            'regoins' => $this->regoins,
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
