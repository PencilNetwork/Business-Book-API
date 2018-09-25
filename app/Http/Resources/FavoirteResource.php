<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FavoirteResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'bussines_id' => $this->bussines_id,
            'searcher_id' => $this->searcher_id,
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
