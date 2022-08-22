<?php

declare(strict_types=1);

namespace App\Services\CommissionFee\CommissionOperationStrategy;

use App\Dictionaries\OperationDictionary;
use App\Services\CommissionFee\CommissionFeePayload;
use App\Services\CommissionFee\Exceptions\CommissionOperationException;
use Illuminate\Foundation\Application;
use ReflectionException;

class CommissionOperationContext
{
    public function __construct(protected Application $app)
    {
    }

    /**
     * @throws CommissionOperationException|ReflectionException
     */
    public function execute(CommissionFeePayload $commissionFeePayload)
    {
        foreach (OperationDictionary::toArray() as $strategy) {
            if ($commissionFeePayload->getOperation() === $strategy) {
                return $this->app->make($this->resolveStrategyClass($strategy))->handle($commissionFeePayload);
            }
        }

        throw new CommissionOperationException('Commission operation is not supported.');
    }

    private function resolveStrategyClass(string $strategy): string
    {
        return sprintf("%s\\%sStrategy", __NAMESPACE__, ucwords($strategy));
    }
}
