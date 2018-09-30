<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OfferResource extends Resource
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
            'data'=> [
            'id' => $this->id,
            'caption' => $this->caption,
            'image' => "https://pencilnetwork.com/bussines_book/public/images/".$this->image,
            'bussines_id' => $this->bussines->id,
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
        ]];
        // return parent::toArray($request);
    }
}
