<?php

declare(strict_types=1);

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

use App\Services\CommissionFee\CommissionFeePayload;

class WithdrawBusinessUser implements WithdrawUserTypeInterface
{
    public function apply(CommissionFeePayload $commissionFeePayload): int|float
    {
        return  ($commissionFeePayload->getAmount() * 0.5)/100;
    }
}
