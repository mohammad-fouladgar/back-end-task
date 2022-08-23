<?php

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

use App\Services\CommissionFee\CommissionFeePayload;

class WithdrawBusinessUser implements WithdrawUserTypeInterface
{
    public function apply(CommissionFeePayload $commissionFeePayload): int|float
    {
        return ceil($commissionFeePayload->getAmount() * 0.5) / 100;
    }
}
