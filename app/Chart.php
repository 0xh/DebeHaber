<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    //
    public function getTypeAttribute($attribute)
    {
        return new ChartTypeEnum($attribute);
    }

    public function getSubTypeAttribute($attribute)
    {
        if ($this->attributes['type'] == 1) {
            return new ChartAssetTypeEnum($attribute);
        }
        elseif($this->attributes['type'] == 2) {
            return new ChartLiabilityTypeEnum($attribute);
        }
        elseif($this->attributes['type'] == 3) {
            return new ChartEquityTypeEnum($attribute);
        }
        elseif($this->attributes['type'] == 4) {
            return new ChartRevenueTypeEnum($attribute);
        }
        //If all else fails, Expense is the most common SubType
        return new ChartExpenseTypeEnum($attribute);
    }

    public function setTypeAttribute(ChartTypeEnum $attribute) {
        $this->attributes['type'] = $attribute->getValue();
    }

    public function setAssetAttribute(ChartAssetTypeEnum $attribute) {
        $this->attributes['sub_type'] = $attribute->getValue();
    }

    public function setLiabilityAttribute(ChartLiabilityTypeEnum $attribute) {
        $this->attributes['sub_type'] = $attribute->getValue();
    }

    public function setEquityAttribute(ChartEquityTypeEnum $attribute) {
        $this->attributes['sub_type'] = $attribute->getValue();
    }

    public function setRevenueAttribute(ChartRevenueTypeEnum $attribute) {
        $this->attributes['sub_type'] = $attribute->getValue();
    }

    public function setExpenseAttribute(ChartExpenseTypeEnum $attribute) {
        $this->attributes['sub_type'] = $attribute->getValue();
    }

    /**
    * Get the version that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function version()
    {
        return $this->belongsTo(ChartVersion::class);
    }

    /**
    * Get the aliases for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function aliases()
    {
        return $this->hasMany(ChartAlias::class, 'foreign_key', 'local_key');
    }

    /**
    * Get the owner that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function taxPayer()
    {
        return $this->belongsTo(Taxpayer::class);
    }

    /**
    * Get the partner that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function partner()
    {
        return $this->belongsTo(Taxpayer::class);
    }

    /**
    * Get the fixedAssets for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function fixedAssets()
    {
        return $this->hasMany(FixedAsset::class);
    }

    /**
    * Get the transactions for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
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
    * Get the productionDetails for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function productionDetails()
    {
        return $this->hasMany(ProductionDetail::class);
    }

    /**
    * Get the transactionDetails for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    /**
    * Get the journalDetails for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function journalDetails()
    {
        return $this->hasMany(JournalDetail::class);
    }

    /**
    * Get the journalSimDetail for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function journalSimDetail()
    {
        return $this->hasMany(JournalSimDetail::class);
    }

    /**
    * Get the journalTemplateDetails for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function journalTemplateDetails()
    {
        return $this->hasMany(JournalTemplateDetail::class);
    }

    /**
    * Get the cycleBudgets for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function cycleBudgets()
    {
        return $this->hasMany(CycleBudget::class);
    }
}
