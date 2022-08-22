<?php

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

use App\Services\CommissionFee\CommissionFeePayload;

interface WithdrawUserTypeInterface
{
    public function apply(CommissionFeePayload $commissionFeePayload): int|float;
}
