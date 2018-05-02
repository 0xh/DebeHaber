<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaxpayerSetting extends Model
{
    public $timestamps  = false;
    
    public function taxpayer()
    {
        return $this->hasOne(Taxpayer::class);
    }
}
