<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxpayerSetting extends Model
{
    protected $fillable = [
      'agent_name'

  ];
    public $timestamps  = false;

    public function taxpayer()
    {
        return $this->belongsTo('App\Taxpayer','taxpayer_id','id');
    }
}
