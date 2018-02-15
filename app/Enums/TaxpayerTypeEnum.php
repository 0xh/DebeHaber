<?php

namespace App\Enums;

use Nasyrov\Laravel\Enums\Enum;

class TaxpayerTypeEnum extends Enum
{
    const IRACIS   = 1;
    const IVA      = 2;
    const IRAGRO   = 3;
    const IRP      = 4;
}
