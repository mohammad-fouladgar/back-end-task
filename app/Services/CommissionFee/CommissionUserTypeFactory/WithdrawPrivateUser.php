<?php

declare(strict_types=1);

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

use App\Services\CommissionFee\CommissionFeePayload;

class WithdrawPrivateUser implements WithdrawUserTypeInterface
{
    public function apply(CommissionFeePayload $commissionFeePayload): int|float
    {
        //todo: should be calculate
        return 1010;
    }
}
