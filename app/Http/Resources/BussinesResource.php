<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\Facades\DB; 
use App\File;
use App\Offer;
// use App\;
// use App\;\
// use App\;
class BussinesResource extends Resource
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
            'name' => $this->name,
            'image' => "https://pencilnetwork.com/bussines_book/public/images/".$this->image,
            'description' => $this->description,
            'logo' => "https://pencilnetwork.com/bussines_book/public/images/".$this->logo,
            'contact_number' => $this->contact_number,
            'city' => $this->city,
            'regoin' => $this->regoin,
            'address' => $this->address,
            'langitude' => $this->langitude,
            'lattitude' => $this->lattitude,
            // 'category' => $this->category,
            'owner_id' => $this->owner->id,
            'average_rating' => $this->averageRating(),
            // 'average_rating' => $this->ratings->avg('rating'),
            // 'files' =>   $this->files,
            'files' =>   FileResource::collection($this->files),
            'offers' =>  OfferResource::collection($this->offers),
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
