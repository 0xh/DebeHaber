<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JournalDetail extends Model
{
    //

    /**
     * Get the journal that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function journal()
    {
        return $this->belongsTo(Journal::class);
    }

    /**
     * Get the chart that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chart()
    {
        return $this->belongsTo(Chart::class);
    }

}
