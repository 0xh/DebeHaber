<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AccountMovementResource extends JsonResource
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
            'ID' =>$this->id,
            'Date' => Date($this->date),
            'Debit' => $this->debit,
            'Credit' => $this->credit,
            'chart' => $this->chart,
            'transaction' => $this->transaction,
            'currency'=>$this->Currency,
        ];
    }
}
