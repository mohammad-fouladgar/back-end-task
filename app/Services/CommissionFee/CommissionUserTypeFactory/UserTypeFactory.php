<?php

declare(strict_types=1);

namespace App\Services\CommissionFee\CommissionUserTypeFactory;

use App\Services\CommissionFee\Exceptions\CommissionUserTypeException;
use Illuminate\Foundation\Application;

class UserTypeFactory
{
    public function __construct(protected Application $app)
    {
    }

    /**
     * @throws CommissionUserTypeException
     */
    public function make(string $userType): WithdrawUserTypeInterface
    {
        /** @var WithdrawUserTypeInterface $userTypeClass */
        $userTypeClass = $this->app->make($this->resolveUserTypeClass($userType));

        if (!$userTypeClass instanceof WithdrawUserTypeInterface) {
            throw new CommissionUserTypeException('Commission user type is not supported.');
        }

        return $userTypeClass;
    }

    private function resolveUserTypeClass(string $userType): string
    {
        return sprintf("%s\\Withdraw%sUser", __NAMESPACE__, ucwords($userType));
    }
}
