<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
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


    /**
     * Get the accountChart that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountChart()
    {
        return $this->belongsTo(Chart::class);
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
        return $this->belongsTo(Currency::class);
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
    public function journals()
    {
        return $this->hasMany(JournalTransaction::class);
    }

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
