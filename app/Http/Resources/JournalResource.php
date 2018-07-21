<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalResource extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    public function toArray($request)
    {
         return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'date' => $this->name,
        //     'number' => $this->number,
        //     'comment' => $this->comment,
        //     'is_presented' => $this->is_presented,
        //     'details' => JournalDetailResource::collection($this->whenLoaded('details')),
        // ];
    }
}
