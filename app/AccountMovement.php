<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;
use App\Scopes\AccountMovementScope;

class AccountMovement extends Model
{
    use HasStatuses, SoftDeletes;
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new AccountMovementScope);
    }
    public function scopeMyAccountReceivablesForJournals($query, $startDate, $endDate, $taxPayerID)
    {
        return $query->whereHas('transaction', function ($q) use($taxPayerID)
        {
            $q->where('supplier_id', $taxPayerID)
            ->where('payment_condition', '>', 0);
        })
        ->with('transaction:customer_id,number')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('taxpayer_id', $taxPayerID);
    }

    /*
    Gets the account payables where payment_condition is greater than 0.
    */
    public function scopeMyAccountPayablesForJournals($query, $startDate, $endDate, $taxPayerID)
    {
        //TODO change query to focus on transaction with whereHas('AccountMovement')
        //this will allow to focus more on the sum of payments made, instead of each payment made in the time frame.

        return $query->whereHas('transaction', function ($q) use($taxPayerID)
        {
            $q->where('customer_id', $taxPayerID)
            ->where('payment_condition', '>', 0);
        })
        ->with('transaction:supplier_id,number')
        ->whereBetween('date', [$startDate, $endDate])
        ->where('taxpayer_id', $taxPayerID);
    }

    /**
    * Get the transaction that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
    * Get the chart that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function chart()
    {
        return $this->belongsTo(Chart::class,'chart_id')->withoutGlobalScopes();
    }

    /**
    * Get the currency that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
    * Get the taxPayer that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function taxPayer()
    {
        return $this->belongsTo(Taxpayer::class);
    }
}
