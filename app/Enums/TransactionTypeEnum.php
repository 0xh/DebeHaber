<?php

namespace App\Enums;

use Nasyrov\Laravel\Enums\Enum;

class TransactionTypeEnum extends Enum
{
    const Invoice           = 1;
    const DebitNote         = 2;
    const CreditNote        = 3;
    const CustomsClearence  = 4;
    const SelfInvoice       = 5;
    const Ticket            = 6;
    const AirTicket         = 7;
    const ForeignInvoices   = 8;


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
