<?php

namespace App\Http\Controller\API;

use App\Taxpayer;
use App\Chart;
use App\Cycle;
use App\ChartAlias;
use App\Transaction;
use App\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    // public function formatData($data)
    // {
    //     return Transaction::make($data)->resolve();
    // }

    public function start(Request $request)
    {
        //Convert data from
        $data = collect(json_decode($request, true));

        //Process Transaction by 100 to speed up but not overload.
        foreach ($data->chunk(100) as $chunkedData)
        {
            $this->processTransaction($chunkedData);
        }
    }

    public function processTransaction($data, $taxpayer, $cycle)
    {
        // //process transaction
        //
        // //process detail
        // $details = $data->detail;
        // $this->processDetail($details);
        // //return transaction saved status (ok or error).
        //
        // $transactions = array(
        //     array('user_id'=>'Coder 1', 'subject_id'=> 4096),
        //     array('user_id'=>'Coder 2', 'subject_id'=> 2048),
        // );
        //
        // Model::insert($transactions);

        //TODO. There should be logic that checks if RefID for this Taxpayer is already int the system. If so, then only update, or else create.
        //Im not too happy with this code since it will call db every time there is a new invoice. Maybe there is a better way, or simply remove this part and insert it again.
        $transaction = Transaction::where('ref_id', $request->id)->first() ?? new Transaction();

        if ($data->type == 1 || $data->type == 3)
        {
            $customer = $this->checkTaxPayer($data->customerTaxID, $data->customerName);
            $supplier = $taxpayer;
        }
        else if($data->type == 2 || $data->type == 4)
        {
            $customer = $taxpayer;
            $supplier = $this->checkTaxPayer($data->supplierTaxID, $data->supplierName);
        }

        $transaction->type = $data->type;

        $cycle = Cycle::where('taxpayer_id', $taxPayer->id)->first();

        $transaction->customer_id = $customer->id;
        $transaction->supplier_id = $supplier->id;

        $transaction->currency_id = $this->checkCurrency($data->currency, $taxpayer);

        //TODO, this is not enough. Remove Cycle, and exchange that for Invoice Date. Since this will tell you better the exchange rate for that day.
        $transaction->rate = $this->checkCurrencyRate($transaction->currency_id, $taxpayer, $request->date);

        $transaction->payment_condition = $request->payment_condition;

        //TODO, do not ask if chart account id is null.
        if ($transaction->account != null)
        {
            $transaction->chart_account_id = $this->checkChartAccount($transaction->account, $taxpayer, $cycle);
        }

        //You may need to update the code to a Carbon nuetral. Check this, I may be wrong.
        $transaction->date = $request->date;
        $transaction->number = $request->number;
        $transaction->code = $request->code != '' ? $request->code : null;
        $transaction->code_expiry = $request->code_expiry != '' ? $request->code_expiry : null;
        $transaction->comment = $request->comment;
        $transaction->ref_id = $request->id;
        $transaction->save();

        $this->processDetail($request->details,$transaction->id);
    }

    public function processDetail($details, $transaction_id)
    {
        foreach ($details as $detail)
        {
            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_id = $transaction_id;
            $transactionDetail->chart_id = $this->checkChart($detail['chart'], $taxpayer, $cycle);
            $transactionDetail->chart_vat_id = $this->checkChartVat($detail['vat'], $taxpayer, $cycle);
            $transactionDetail->value = $detail['value'];
            $transactionDetail->ref_id = $request->id;
            $transactionDetail->save();
        }
    }

    public function checkTaxPayer($taxid, $name)
    {
        //This code is a good chance to make sure un necesary code doesn't get inserted into database.
        //Sometimes users write information that is not acceptable by government, and the accountant needs to clean up.
        //For example, if a foreigner buys sometime, their taxid is not recognized by government.
        //So the accountant will change to a default taxpayer. Here we should do the same based on the country add a function
        //and logic per country that detects if the value passed is a proper taxid or not. If not then give a default taxpayer that is meant to be used in those conditions.

        if ($name != '')
        {
            //TODO Clean up $code to remove extra '-', '.' and ',' from the code to search in a clean manner.
            //if there is a -, then it will remove everything after it.
            $taxid = $taxid.contains('-') ? strstr($taxid, '-', true) : $taxid;
            //removes all letters and only keeps numbers.
            $taxid = preg_replace('/[^0-9.]+/', '', $taxid);

            $taxPayer = Taxpayer::where('taxid', $taxid)->first() ?? new Taxpayer();

            //get code from taxid. create function based on country.
            //run function based on country.

            //TODO Country from Selection Box
            $taxPayer->name = $name;
            $taxPayer->taxid = $taxid;
            $taxPayer->code = $code;

            $taxPayer->save();

            return $taxPayer;
        }
    }

    //These Charts will not work as they use the global scope for Taxpayer and Cycle.
    //you will have to call no global scopes for these methods and then manually assign the same query.

    public function checkChart($name,$taxpayer,$cycle)
    {
        //Check if Chart Exists
        if ($name != '')
        {
            $chart = Chart::SalesAccounts()->where('name', $name)->first();

            if ($chart == null)
            {
                $chart = new Chart();

                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = $taxPayer->country;
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = 1;
                $chart->sub_type = 9;
                $chart->type = 1;

                $chart->code = $name;
                $chart->name = $name;
                $chart->save();
            }
            return $chart->id;
        }
        return null;
    }

    public function checkChartVat($name,$taxpayer,$cycle)
    {
        //Check if Chart Exists
        if ($name != '')
        {
            $chart = Chart::VATDebitAccounts()->where('name', $name)->first();

            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = $taxPayer->country;
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = 1;
                $chart->type = 2;
                $chart->sub_type = 3;

                $chart->code = $name;
                $chart->name = $name;
                $chart->save();
            }

            return $chart->id;
        }

        return null;
    }

    public function checkChartAccount($name, $taxpayer, $cycle)
    {
        //Check if Chart Exists
        if ($name != '')
        {
            $chart = Chart::MoneyAccounts()->where('name', $name)->first();

            if ($chart == null)
            {
                $chart = new Chart();
                $chart->chart_version_id = $cycle->chart_version_id;
                $chart->country = $taxPayer->country;
                $chart->taxpayer_id = $taxPayer->id;
                $chart->is_accountable = 1;
                $chart->type = 1;
                $chart->sub_type = 3;

                $chart->code = 'N/A';
                $chart->name = $name;
                $chart->save();

            }

            return $chart->id;
        }

        return null;
    }
}
