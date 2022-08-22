<?php

declare(strict_types=1);

namespace App\Services\CommissionFee;

class CommissionFeePayload
{
    public function __construct(
        private string $date,
        private string $userId,
        private string $userType,
        private string $operation,
        private string $amount,
        private string $currency,
    ) {
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getUserType(): string
    {
        return $this->userType;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function getAmount(): string
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }
}
