<?php

namespace App\Enums;

use Nasyrov\Laravel\Enums\Enum;

class ChartTypeEnum extends Enum
{
    const Assets            = 1;
    const Liabilities       = 2;
    const Capital           = 3;
    const Revenues          = 4;
    const Expenses          = 5;
}
