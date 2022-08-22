<?php

namespace App\Services\CommissionFee\CommissionOperationStrategy;

use App\Services\CommissionFee\CommissionFeePayload;
use App\Services\CommissionFee\CommissionUserTypeFactory\UserTypeFactory;
use App\Services\CommissionFee\Exceptions\CommissionUserTypeException;

class WithdrawStrategy implements CommissionOperationStrategyInterface
{
    public function __construct(private UserTypeFactory $userTypeFactory)
    {
    }

    /**
     * @throws CommissionUserTypeException
     */
    public function handle(CommissionFeePayload $commissionFeePayload): string
    {
        return $this->userTypeFactory->make($commissionFeePayload->getUserType())->apply($commissionFeePayload);
    }
}
