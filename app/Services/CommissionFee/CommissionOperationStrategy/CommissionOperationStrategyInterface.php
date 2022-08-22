<?php

namespace App\Services\CommissionFee\CommissionOperationStrategy;

use App\Services\CommissionFee\CommissionFeePayload;

interface CommissionOperationStrategyInterface
{
    public function handle(CommissionFeePayload $commissionFeePayload): string;
}
