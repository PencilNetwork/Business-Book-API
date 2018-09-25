<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;
// use App\Http\Resources\BussinesResource; 

class OwnerResource extends Resource
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
            'owner_id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'password'  => $this->password,
            'token'     => $this->token,
            // 'bussines' => BussinesResource::collection($this->bussines) ,
            // 'bussines' => new BussinesResource($this->bussines),
            'bussines' => $this->bussines,
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
