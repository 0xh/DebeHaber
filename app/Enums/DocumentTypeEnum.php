<?php

namespace App\Enums;

use Nasyrov\Laravel\Enums\Enum;

class DocumentTypeEnum extends Enum
{
    const Invoice           = 1;
    const DebitNote         = 2;
    const CreditNote        = 3;
    const SelfInvoice       = 5;
    const Ticket            = 6;
}
