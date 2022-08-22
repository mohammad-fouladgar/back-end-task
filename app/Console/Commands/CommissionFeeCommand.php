<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\CommissionFee\CommissionFeeCalculationService;
use App\Services\CommissionFee\CommissionFeePayload;
use Illuminate\Console\Command;
use Throwable;

class CommissionFeeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'commission-fee:calculate {csv-file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Commission fee calculation.';

    public function handle(CommissionFeeCalculationService $commissionFeeCalculationService): int
    {
        try {
            if (!$handle = fopen($this->argument('csv-file'), 'r')) {
                $this->error('Unable to read csv file.');

                return 1;
            }
            while ($row = fgetcsv($handle, 1000)) {
                $commissionFeePayload = new CommissionFeePayload($row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
                $this->info($commissionFeeCalculationService->calculate($commissionFeePayload));
            }
            fclose($handle);
        } catch (Throwable $throwable) {
            $this->error($throwable->getMessage());

            return 1;
        }

        return 0;
    }
}
