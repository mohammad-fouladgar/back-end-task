<?php

namespace App\Services\CommissionFee\CommissionOperationStrategy;

use App\Services\CommissionFee\CommissionFeePayload;

class DepositStrategy implements CommissionOperationStrategyInterface
{
    public function handle(CommissionFeePayload $commissionFeePayload): string
    {
        return ($commissionFeePayload->getAmount() * 0.3) / 100;
    }
}
