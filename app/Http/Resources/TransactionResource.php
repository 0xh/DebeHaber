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
            'ID' =>$this->resource['id'],
            'Customer' => $this->resource['tax_payer.name'],
            'CustomerTaxID' => $this->resource['tax_payer.taxid'],
            'Currency' => $this->resource['currency.code'],
            'PaymentCondition' => $this->resource['payment_condition'],
            'Date' => $this->resource['date'],
            'Number' => $this->resource['number'],
            'Status' => $this->resource['Status.name'],
            //When Loaded will only bring if "with('details')" is used in eloquent call. Only if eager loaded.
            'details' => $this->resource['details']

        ];
        //return parent::toArray($request);
    }
}
