<?php

namespace App\Enums;

use Nasyrov\Laravel\Enums\Enum;

class ChartAssetTypeEnum extends Enum
{
    const BankAccount               = 1;
    const PayrollAccount            = 2;
    const PettyCash                 = 3;
    const MarketableSecurities      = 4;
    const AccountsReceivable        = 5;
    const AllowanceDoubtfulAccounts = 6; //(contra account)
    const PrepaidExpenses           = 7;
    const Inventory                 = 8;
    const FixedAssets               = 9;
    const AccumulatedDepreciation   = 10; //(contra account)
    const OtherAssets               = 11;
    const SalesTaxReceivable        = 12;
}
