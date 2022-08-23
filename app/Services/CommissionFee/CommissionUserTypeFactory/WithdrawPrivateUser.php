<?php

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

use App\Services\CommissionFee\CommissionFeePayload;
use Exception;
use Illuminate\Http\Client\RequestException;

class WithdrawPrivateUser implements WithdrawUserTypeInterface
{
    private static array $currencyRates = [];

    public function __construct(
        private FetchCurrencyExchangeRatesAction $fetchCurrencyExchangeRatesAction,
        private UserTransactionsRepository $userTransactionsRepository,
    ) {
    }

    /**
     * @throws RequestException|Exception
     */
    public function apply(CommissionFeePayload $commissionFeePayload): int|float
    {
        $commission = 0;
        if ($this->HasTransactionMoreThanThreeTimesInWeek($commissionFeePayload)) {
            $commission = ceil($commissionFeePayload->getAmount() * 0.3) / 100;
        } elseif ($this->isExceeded($commissionFeePayload)) {
            $commission = ceil($this->getExceededAmount($commissionFeePayload) * 0.3) / 100;
        }

        $this->userTransactionsRepository->setUserTransactions(
            $commissionFeePayload->getUserId(),
            $commissionFeePayload->getDate(),
            $this->convertAmountToEUR($commissionFeePayload->getAmount(), $commissionFeePayload->getCurrency())
        );

        return $commission;
    }

    /**
     * @throws Exception
     */
    private function getExceededAmount(CommissionFeePayload $commissionFeePayload): float
    {
        $userTransactions = $this->userTransactionsRepository->getTransactionsByUserId($commissionFeePayload->getUserId());
        $rangeWeek        = get_start_and_end_of_week($commissionFeePayload->getDate());
        $sumAmount        = 0;

        foreach ($userTransactions as $date => $amount) {
            if ($date >= $rangeWeek['start_date'] && $date <= $rangeWeek['end_date']) {
                $sumAmount += $amount;
            }
        }

        $EURAmount = $this->convertAmountToEUR(
            $commissionFeePayload->getAmount(),
            $commissionFeePayload->getCurrency()
        );

        $exceededAmount = $sumAmount > 1000 ? $EURAmount : ($EURAmount + $sumAmount) - 1000;

        return $exceededAmount * $this->getRateByCurrency($commissionFeePayload->getCurrency());
    }

    /**
     * @throws RequestException|Exception
     */
    private function isExceeded(CommissionFeePayload $feePayload): bool
    {
        $userTransactions = $this->userTransactionsRepository->getTransactionsByUserId($feePayload->getUserId());
        $baseAmount       = $this->convertAmountToEUR($feePayload->getAmount(), $feePayload->getCurrency());
        $rangeWeek        = get_start_and_end_of_week($feePayload->getDate());

        foreach ($userTransactions as $date => $amount) {
            if ($date >= $rangeWeek['start_date'] && $date <= $rangeWeek['end_date']) {
                $baseAmount += $amount;
            }
        }

        return $baseAmount > 1000;
    }

    /**
     * @throws Exception
     */
    private function HasTransactionMoreThanThreeTimesInWeek(CommissionFeePayload $commissionFeePayload): bool
    {
        $userTransactions = $this->userTransactionsRepository->getTransactionsByUserId($commissionFeePayload->getUserId());
        $rangeWeek        = get_start_and_end_of_week($commissionFeePayload->getDate());

        $counter = 1;
        foreach ($userTransactions as $date => $amount) {
            if ($date >= $rangeWeek['start_date'] && $date <= $rangeWeek['end_date']) {
                $counter++;
            }
        }

        return $counter > 3;
    }

    /**
     * @throws RequestException
     */
    private function convertAmountToEUR(string $amount, string $currency): int|float
    {
        return $currency === 'EUR' ?
            $amount :
            $amount / $this->getRateByCurrency($currency);
    }

    /**
     * @throws RequestException
     */
    private function getRateByCurrency(string $currency)
    {
        return $this->fetchCurrencies()[$currency];
    }

    /**
     * @throws RequestException
     */
    private function fetchCurrencies(): array
    {
        if (count(self::$currencyRates)) {
            return self::$currencyRates;
        }

        self::$currencyRates = $this->fetchCurrencyExchangeRatesAction->execute();

        return self::$currencyRates;
    }
}
