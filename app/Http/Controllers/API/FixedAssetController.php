<?php

namespace App\Http\Controller\API;

use App\FixedAsset;
use App\Taxpayer;
use App\Cycle;
use App\ChartAlias;
use Illuminate\Http\Request;

class FixedAssetController extends Controller
{
    public function start(Request $request)
    {
        $movementData = array();

        $startDate = '';
        $endDate = '';

        $cycle = null;

        //Process Transaction by 100 to speed up but not overload.
        for ($i = 0; $i < 100 ; $i++)
        {
            $chunkedData = $request[$i];

            if (isset($chunkedData))
            {
                $taxPayer = $this->checkTaxPayer($chunkedData['TaxpayerTaxID'], $chunkedData['TaxpayerName']);

                try
                {
                    $fixedAsset = $this->processTransaction($chunkedData, $taxPayer);
                    $movementData[$i] = $fixedAsset;
                }
                catch (\Exception $e)
                {
                    //Write items that don't insert into a variable and send back to ERP.
                    //Do Nothing
                }
            }
        }

        return response()->json($movementData);
    }

    public function insertFixedAsset($data, Taxpayer $taxPayer)
    {
        $fixedAsset = FixedAsset::where('serial', $data['Serial']) ?? new FixedAsset();
        $fixedAsset->taxpayer_id = $taxPayer->id;
        $fixedAsset->currency_id = $this->checkCurrency($data['CurrencyCode'], $taxPayer);

        if ($data['CurrencyRate'] ==  '' )
        { $fixedAsset->rate = $this->checkCurrencyRate($fixedAsset->currency_id, $taxPayer, $data['Date']) ?? 1; }
        else
        { $fixedAsset->rate = $data['CurrencyRate'] ?? 1; }

        $fixedAsset->serial = $data['Serial'];
        $fixedAsset->name = $data['Name'];
        $fixedAsset->purchase_date = $this->convert_date($data['PurchaseDate']);
        $fixedAsset->purchase_value = $this->convert_date($data['PurchaseValue']);
        $fixedAsset->quantity = $data['Quantity'];
        //Take todays date to keep track of how new data really is.
        $fixedAsset->sync_date = Carbon::now();
        $fixedAsset->save();
        //Return account movement if not null.
        return $fixedAsset != null ? $fixedAsset : null;
    }
}
