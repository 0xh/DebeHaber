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
            'Customer' => $this->resource['taxPayer.name'],
            'CustomerTaxID' => $this->resource['taxPayer.taxid'],
            'Currency' => $this->resource['currency.code'],
            'PaymentCondition' => $this->resource['payment_condition'],
            'PaymentCondition' => $this->resource['payment_condition'],
            'Date' => $this->resource['date'],
            'Number' => $this->resource['number'],
            'Status' => $this->resource['Status.name'],

            'expiryDate' => $this->resource['expiry_date']
        ];
        //return parent::toArray($request);
    }
}
