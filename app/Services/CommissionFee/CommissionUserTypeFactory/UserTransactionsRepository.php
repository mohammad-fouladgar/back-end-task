<?php

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

class UserTransactionsRepository
{
    private static array $transactions = [];

    public function setUserTransactions(string $userId, string $date, float $amount): void
    {
        if (isset(self::$transactions[$userId][$date])) {
            self::$transactions[$userId][$date] += $amount;
        } else {
            self::$transactions[$userId][$date] = $amount;
        }
    }

    public function getTransactionsByUserId(string $userId): array
    {
        return self::$transactions[$userId] ?? [];
    }
}
