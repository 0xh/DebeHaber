<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CycleBudget extends Model
{
    //

    /**
     * Get the cycle that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cycle()
    {
        return $this->belongsTo(Cycle::class, 'foreign_key', 'local_key');
    }

    /**
     * Get the chart that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chart()
    {
        return $this->belongsTo(Chart::class, 'foreign_key', 'local_key');
    }
}
