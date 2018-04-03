<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JournalDetail extends JsonResource
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
            'chartName' => $this->whenLoaded('chart')->name,
            'chartCode' => $this->whenLoaded('chart')->code,
            'credit' => $this->credit,
            'debit' => $this->debit,
        ];
    }
}
