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
        // return [
        //     'date' => $request->resource['date'],
        //     'invoiceNumber' => $this->resource['number'],
        //     'invoiceCode' => $this->resource['code'],
        //     'expiryDate' => $this->resource['expiry_date'],
        //
        //     'customerName' => $this->resource['customer.name'],
        //     'customerTaxID' => $this->resource['customer.taxid'],
        //     'supplierName' => $this->resource['supplier.name'],
        //     'supplierTaxID' => $this->resource['supplier.taxid'],
        //     //When Loaded will only bring if "with('details')" is used in eloquent call. Only if eager loaded.
        //     'details' => TransactionDetailResource::collection($this->whenLoaded('details')),
        //     'refID' => $this->resource['refID']
        // ];
          return parent::toArray($request);
    }
}
