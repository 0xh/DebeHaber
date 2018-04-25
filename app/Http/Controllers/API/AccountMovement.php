<?php

namespace App\Http\Controller\API;

use App\AccountMovement;
use App\Taxpayer;
use App\Cycle;
use App\ChartAlias;
use Illuminate\Http\Request;

class AccountMovementController extends Controller
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

                if ($chunkedData['Type'] == 4 || $chunkedData['Type'] == 5)
                { $taxPayer = $this->checkTaxPayer($chunkedData['SupplierTaxID'], $chunkedData['SupplierName']); }
                else if($chunkedData['Type'] == 3 || $chunkedData['Type'] == 1)
                { $taxPayer = $this->checkTaxPayer($chunkedData['CustomerTaxID'], $chunkedData['CustomerName']); }

                //No need to run this query for each invoice, just check if the date is in between.
                $cycle = Cycle::where('start_date', '<=', $this->convert_date($chunkedData['Date']))
                ->where('end_date', '>=', $this->convert_date($chunkedData['Date']))
                ->where('taxpayer_id', $taxPayer->id)
                ->first();

                if (!isset($cycle))
                {
                    $current_date = Carbon::now();
                    $version = ChartVersion::where('taxpayer_id', $taxPayer->id)->first();

                    if (!isset($version))
                    {
                        $version = new ChartVersion();
                        $version->taxpayer_id = $taxPayer->id;
                        $version->name = 'Version Automatica';
                        $version->save();
                    }

                    $cycle = new Cycle();
                    $cycle->chart_version_id = $version->id;
                    $cycle->year = $current_date->year;
                    $cycle->start_date = new Carbon('first day of January');
                    $cycle->end_date = new Carbon('last day of December');
                    $cycle->taxpayer_id = $taxPayer->id;
                    $cycle->save();
                }
                else
                {
                    $startDate = $cycle->start_date;
                    $endDate = $cycle->end_date;
                }

                try
                {
                    $accMovement = $this->processTransaction($chunkedData, $taxPayer, $cycle);
                    $movementData[$i] = $accMovement;
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

    public function formatData($data)
    {
        return Transaction::make($data)->resolve();
    }

    public function processTransaction($data, Taxpayer $taxPayer, Cycle $cycle)
    {
        //Check if
        if ($data['Type'] == 1) //Payment Made (Account Payable)
        {
            $customer = $taxPayer;
            $supplier = $this->checkTaxPayer($data['SupplierTaxID'], $data['SupplierName']);

            $transaction = Transaction::where('supplier_id', $supplier->id)
            ->where('customer_id', $customer->id)
            ->where('number', $data['Number'])
            ->whereIn('type', [1, 2])
            ->first();

            if ($transaction != null)
            {
                $accMovement = processPayments($data, $invoice);
            }
        }
        else if ($data['Type'] == 2) //Payment Received (Account Receivables)
        {
            $customer = $this->checkTaxPayer($data['CustomerTaxID'], $data['CustomerName']);
            $supplier = $taxPayer;

            $transaction = Transaction::where('supplier_id', $supplier->id)
            ->where('customer_id', $customer->id)
            ->where('number', $data['Number'])
            ->where('type', 4)
            ->first();

            if ($transaction != null)
            {
                $accMovement = processPayments($data, $invoice);
            }
        }
        else //simple Transfer
        {
            $accMovement = processMovement($data);
        }

        //Return account movement if not null.
        return $accMovement != null ? $accMovement : null;
    }

    public function processPayments($data, $invoice)
    {
        $accMovement = new AccountMovement();



        return $accMovement;
    }

    public function processMovement($data)
    {
        $accMovement = new AccountMovement();



        return $accMovement;
    }
}
