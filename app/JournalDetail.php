<?php

namespace App;

use Spatie\BinaryUuid\HasBinaryUuid;
use Illuminate\Database\Eloquent\Model;

class JournalDetail extends Model
{
    use HasBinaryUuid;
    protected $fillable = [
        'type',
        'journal_id',
        'chart_id',
        'debit',
        'credit',
    ];

    public function getKeyName()
    {
        return 'id';
    }
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
