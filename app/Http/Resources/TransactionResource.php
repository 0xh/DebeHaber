<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'Customer' => $this->customer->name,
            'CustomerTaxID' => $this->customer->taxid,
            'Supplier' => $this->supplier->name,
            'SupplierTaxID' => $this->supplier->taxid,
            'Currency' => $this->currency->code,
            'PaymentCondition' => $this->payment_condition,
            'Date' => Date($this->date),
            'Number' => $this->number,
            'Value' => $this->details->sum('value'),
            //'Status' => $this->Status->name,
            //When Loaded will only bring if "with('details')" is used in eloquent call. Only if eager loaded.
            'details' => $this->details
        ];
        //return parent::toArray($request);
    }
}
