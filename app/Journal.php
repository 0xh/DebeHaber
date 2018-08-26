<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\BinaryUuid\HasBinaryUuid;
use App\Scopes\JournalScope;

use App\Cycle;
use App\JournalDetail;
use App\Taxpayer;
use App\JournalProduction;
use App\JournalTransaction;
use App\JournalAccountMovement;
use App\JournalSim;

class Journal extends Model
{
    use HasBinaryUuid;

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new JournalScope);
    }

    protected $fillable = [
        'cycle_id',
        'number',
        'date',
        'comment',
        'is_accountable',
        'is_presented',
        'is_first',
        'is_last',
    ];

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
        return $this->hasMany(JournalDetail::class, 'journal_id', 'id')->orderBy('credit', 'desc');
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
    * Get the accountMovements for the model.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function accountMovements()
    {
        return $this->hasMany(JournalAccountMovement::class);
    }

    /**
    * Get only the total value from details.
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function total()
    {
        return $this->hasMany(JournalDetail::class)
        ->selectRaw('sum(credit) as total');
    }
}
