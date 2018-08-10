<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Spatie\BinaryUuid\HasBinaryUuid;

use App\Cycle;
use App\Scopes\JournalScope;
use App\JournalDetail;
use App\Taxpayer;
use App\JournalProduction;
use App\JournalTransaction;
use App\JournalAccountMovement;
use App\JournalSim;

class Journal extends Model
{
    use HasBinaryUuid;
    public $incrementing = false;
    public $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new JournalScope);
    }

    public function getKeyName()
    {
        return 'id';
    }

    /**
    * Get the details for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function details()
    {
        return $this->hasMany(JournalDetail::class, 'journal_id');
    }

    public function transactions()
    {
        return $this->hasManyThrough('App\Transaction', 'App\JournalTransaction');
    }

    /**
    * Get the journalSimulations for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function journalSimulations()
    {
        return $this->hasMany(JournalSim::class);
    }

    /**
    * Get the cycle that owns the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    /**
    * Get the productions for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function productions()
    {
        return $this->hasMany(JournalProduction::class);
    }

    /**
    * Get the transactions for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    // public function transactions()
    // {
    //     return $this->hasMany(JournalTransaction::class);
    // }

    /**
    * Get the accountMovements for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function accountMovements()
    {
        return $this->hasMany(JournalAccountMovement::class);
    }
}
