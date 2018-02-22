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


        public static function labels()
        {
            return static::constants()
                ->flip()
                ->map(function ($key) {
                    // Place your translation strings in `resources/lang/en/enum.php`
                    return trans(sprintf('enum.%s', strtolower($key)));
                })
                ->all();
        }
}
