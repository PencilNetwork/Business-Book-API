<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SearcherResource extends Resource
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
            'social_id' => $this->social_id,
            'token' => $this->token,
            // 'interest'=>  $this->interest(), 
            // 'interest'=>  new  InterestResource($this->interest), 
            'email' =>  $this->email,
            // 'updated_at' => (string) $this->updated_at,
            // 'created_at' => (string) $this->created_at,
        ];
        // return parent::toArray($request);
    }
}
