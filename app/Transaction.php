<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStatus\HasStatuses;
use RyanWeber\Mutators\Timezoned;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;
    use HasStatuses, Timezoned;

    protected $timezoned = ['date', 'created_at', 'updated_at', 'deleted_at'];
    protected $softDelete = true;
    protected $fillable = [
        'type',
        'customer_id',
        'supplier_id',
        'document_id',
        'currency_id',
        'rate',
        'payment_condition',
        'chart_account_id',
        'date',
        'number',
        'code',
        'code_expiry',
        'comment',
    ];

    public function scopeMySales($query)
    {
        $taxPayerID = request()->route('taxPayer')->id ?? request()->route('taxPayer');

        return $query->where('transactions.type', 4)
        ->where('supplier_id', $taxPayerID);
    }

    public function scopeMyCreditNotes($query)
    {
        $taxPayerID = request()->route('taxPayer')->id ?? request()->route('taxPayer');

        return $query->where('transactions.type', 5)
        ->where('supplier_id', $taxPayerID);
    }

    public function scopeMyPurchases($query)
    {
        $taxPayerID = request()->route('taxPayer')->id ?? request()->route('taxPayer');

        return $query->whereIn('transactions.type', [1, 2])
        ->where('customer_id', $taxPayerID);
    }

    public function scopeMyDebitNotes($query)
    {
        $taxPayerID = request()->route('taxPayer')->id ?? request()->route('taxPayer');

        return $query->where('transactions.type', 3)
        ->where('customer_id', $taxPayerID);
    }

    /**
    * Get the accountChart that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function journals()
    {
        return $this->hasManyThrough('App\Journal', 'App\JournalTransaction');
    }

    /**
    * Get the accountChart that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function accountChart()
    {
        return $this->belongsTo(Chart::class, 'chart_account_id', 'id');
    }

    /**
    * Get the taxPayer that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function taxPayer()
    {
        return $this->belongsTo(Taxpayer::class,'customer_id');
    }

    /**
    * Get the document that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    /**
    * Get the currency that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency_id','id');
    }


    /**
    * Get the accountMovements for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function accountMovements()
    {
        return $this->hasMany(AccountMovement::class);
    }

    /**
    * Get the journals for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    // public function journals()
    // {
    //   return $this->hasMany(JournalTransaction::class);
    // }

    /**
    * Get the details for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
