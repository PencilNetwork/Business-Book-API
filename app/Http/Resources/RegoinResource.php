<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class RegoinResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return  [
            'Place_Id' => $this->Place_Id,
            'Place_Name' => $this->Place_Name,
            'province_id' => $this->province_id,
        ];
        // return parent::toArray($request);
    }
}
