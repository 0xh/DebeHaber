<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\ModelStatus\HasStatuses;

class Inventory extends Model
{
    //
    use SoftDeletes, HasStatuses;


    
}
