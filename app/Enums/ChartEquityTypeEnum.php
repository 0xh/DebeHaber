<?php

namespace App\Enums;

use Nasyrov\Laravel\Enums\Enum;

class ChartEquityTypeEnum extends Enum
{
    const CommonStock       = 1;
    const PreferredStock    = 2;
    const RetainedEarnings  = 3;
}
