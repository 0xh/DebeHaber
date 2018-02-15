<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChartVersion extends Model
{
    //

    /**
     * Get the taxPayer that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function taxPayer()
    {
        return $this->belongsTo(TaxPayer::class);
    }

    /**
     * Get the charts for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function charts()
    {
        return $this->hasMany(Chart::class);
    }

    /**
     * Get the cycles for the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cycles()
    {
        return $this->hasMany(Cycle::class);
    }
}
