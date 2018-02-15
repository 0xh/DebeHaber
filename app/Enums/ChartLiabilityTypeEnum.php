<?php

namespace App\Enums;

use Nasyrov\Laravel\Enums\Enum;

class ChartLiabilityTypeEnum extends Enum
{
    const AccountsPayable    = 1;
    const AccruedLiabilities = 2;
    const SalesTaxPayable    = 3;
    const TaxesPayable      = 4;
    const WagesPayable      = 5;
    const NotesPayable      = 6;
}
