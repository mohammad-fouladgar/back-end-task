<?php

namespace Tests\Feature\Services\CommissionFee;

use App\Dictionaries\UserTypeDictionary;
use App\Services\CommissionFee\CommissionFeeCalculationService;
use App\Services\CommissionFee\CommissionFeePayload;
use App\Services\CommissionFee\Exceptions\CommissionOperationException;
use Tests\TestCase;

class CommissionFeeCalculationServiceTest extends TestCase
{
    private CommissionFeeCalculationService $calculateService;

    public function testCanCalculateCommissionFeeSuccessfully(): void
    {
        $expected      = [0.6, 3, 0, 0.06, 1.5, 0, 0.69, 0.3, 0.3, 3, 0, 0, 8607.4];
        $handle        = fopen(base_path('tests/Dummy/test_input.csv'), "r");
        $expectedIndex = 0;

        while ($row = fgetcsv($handle, 1000)) {
            $commissionFeePayload = new CommissionFeePayload($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
            $this->assertEquals($expected[$expectedIndex], $this->calculateService->calculate($commissionFeePayload));
            $expectedIndex++;
        }

        fclose($handle);
    }

    public function testCanThrowCommissionOperationExceptionIfOperationIsNotValid()
    {
        $commissionFeePayload = new CommissionFeePayload(
            'any_date',
            'any_user_id',
            UserTypeDictionary::BUSINESS,
            'invalid_operation',
            '10',
            'EUR'
        );

        $this->expectException(CommissionOperationException::class);
        $this->calculateService->calculate($commissionFeePayload);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->calculateService = $this->app->make(CommissionFeeCalculationService::class);
    }
}
