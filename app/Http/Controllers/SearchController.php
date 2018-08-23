<?php

namespace App\Http\Controllers;

use App\Taxpayer;
use App\Cycle;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\ModelResource;

class SearchController extends Controller
{
    public function search(Taxpayer $taxPayer, Cycle $cycle, $q)
    {
        $purchases = $this->searchPurchases($taxPayer, $cycle, $q);

        $debits = $this->searchDebits($taxPayer, $cycle, $q);

        $sales = $this->searchSales($taxPayer, $cycle, $q);

        $credits = $this->searchCredits($taxPayer, $cycle, $q);

        $taxPayers = $this->searchTaxPayers($taxPayer, $cycle, $q);

        $foundItems = collect($purchases)
        ->merge($debits)
        ->merge($sales)
        ->merge($credits)
        ->merge($taxPayers);

        //array_push($foundItems, $purchases, $debits, $sales, $credits, $taxPayers);

        //ModelResource::collection($foundItems);

        return view('search')
        ->with('foundItems', $foundItems)
        ->with('q', $q);
    }

    public function searchPurchases(Taxpayer $taxPayer, Cycle $cycle, $q)
    {
        return Transaction::search($q)
        ->where('customer_id', $taxPayer->id)
        ->where('type', 2)
        ->get();
    }

    public function searchDebits(Taxpayer $taxPayer, Cycle $cycle, $q)
    {
        return Transaction::search($q)
        ->where('customer_id', $taxPayer->id)
        ->where('type', 3)
        ->get();
    }

    public function searchSales(Taxpayer $taxPayer, Cycle $cycle, $q)
    {
        return Transaction::search($q)
        ->where('supplier_id', $taxPayer->id)
        ->where('type', 4)
        ->get();
    }

    public function searchCredits(Taxpayer $taxPayer, Cycle $cycle, $q)
    {
        return Transaction::search($q)
        ->where('supplier_id', $taxPayer->id)
        ->where('type', 5)
        ->get();
    }

    public function searchTaxPayers(Taxpayer $taxPayer, Cycle $cycle, $q)
    {
        return Taxpayer::search($q)
        ->get();
    }
}
