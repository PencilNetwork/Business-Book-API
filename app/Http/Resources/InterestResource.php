<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class InterestResource extends Resource
{
   
    public function toArray($request)
    {
        return [
            // 'id' => $this->id,
            'searcher_id' => $this->searcher_id,
            'categories_ids' => $this->categories_ids,
            'city_id' => $this->city_id,
            'regoins_ids' => $this->regoins_ids,
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
