<?php

namespace App\Http\Resources;
use App\Bussines ; 
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
            'owner_id'  => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'password'  => $this->password,
            'token'     => $this->token,
            'bussines' => new BussinesResource(Bussines::where('owner_id',$this->id)->first()),
        ];
    }
}
