<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxpayerIntegration extends Model
{

    public function scopeMyTaxPayers($query, $teamID)
    {
        return $query->join('taxpayers', 'taxpayers.id', 'taxpayer_integrations.taxpayer_id')
        ->where('team_id', $teamID);
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
     * Get the team that owns the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
