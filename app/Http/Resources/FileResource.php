<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class FileResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         // $images  = explode(",", $this->image);
         // $all= null ;
         // $imgs =[];
         // foreach ($images  as $image) {
         //    $imgs[]="https://pencilnetwork.com/bussines_book/public/images/".$image;
         // }
         // foreach($imgs as $image){
         //    if($all== null){
         //        $all = $image ; 
         //    }else {
         //        $all = $all .",".$image;
         //    }
         // }
        return [
            'id' => $this->id,
            'image' => "https://pencilnetwork.com/bussines_book/public/images/".$this->image,
            'bussines_id' => $this->bussines_id,
            // 'created_at' => (string) $this->created_at,
            // 'updated_at' => (string) $this->updated_at,
        ];
        // return parent::toArray($request);
    }
}
