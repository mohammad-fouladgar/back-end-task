<?php

declare(strict_types=1);

namespace App\Services\CommissionFee;

use App\Services\CommissionFee\CommissionOperationStrategy\CommissionOperationContext;

class CommissionFeeCalculationService
{
    public function __construct(private CommissionOperationContext $commissionOperationContext)
    {
    }

    /**
     * @throws Exceptions\CommissionOperationException|\ReflectionException
     */
    public function calculate(CommissionFeePayload $commissionFeePayload): string
    {
        return $this->commissionOperationContext->execute($commissionFeePayload);
    }
}
