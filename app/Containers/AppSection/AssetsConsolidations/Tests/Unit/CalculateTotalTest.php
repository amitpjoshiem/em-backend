<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tests\Unit;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTableTransporter;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\AssetsConsolidations\Tasks\CalculateAssetsConsolidationsTask;
use App\Containers\AppSection\AssetsConsolidations\Tests\TestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Database\Eloquent\Collection;
use function app;

/**
 * Class CalculateTotalTest.
 *
 * @group AssetsConsolidations
 * @group unit
 */
class CalculateTotalTest extends TestCase
{
    /**
     * @test
     */
    public function testCalculateTotal(): void
    {
        /** @var User $user */
        $user   = $this->getTestingUser();
        $member = $this->registerMember($user->getKey());

        $assetsConsolidationsCount = 5;

        $assetsConsolidations = new Collection();
        AssetsConsolidationsTable::factory()->create([
            'member_id' => $member->getKey(),
        ])->each(function (AssetsConsolidationsTable $table) use (&$assetsConsolidations, $member, $assetsConsolidationsCount): void {
            $assetsConsolidations = $assetsConsolidations->merge(AssetsConsolidations::factory()->count($assetsConsolidationsCount)->create([
                'member_id' => $member->getKey(),
                'table_id'  => $table->getKey(),
            ]));
        });

        /** @var OutputAssetsConsolidationsTableTransporter $outputTable */
        $outputTable = app(CalculateAssetsConsolidationsTask::class)->run($assetsConsolidations)->first();
        $calculated  = $outputTable->tableData;
        /** @var OutputAssetsConsolidationsTransporter $total */
        $total = $calculated->pop();

        $totalAmount        = 0;
        $turnover           = 0;
        $trading_cost       = 0;
        $management_expense = 0;
        $wrap_fee           = 0;
        /** @var AssetsConsolidations $assetsConsolidation */
        foreach ($assetsConsolidations as $assetsConsolidation) {
            $totalAmount        += $assetsConsolidation->amount;
            $turnover           += $assetsConsolidation->turnover;
            $trading_cost       += $assetsConsolidation->trading_cost;
            $management_expense += $assetsConsolidation->management_expense;
            $wrap_fee           += $assetsConsolidation->wrap_fee;
        }

        $this->assertEquals($totalAmount, $total->amount);
        $this->assertEquals($turnover / $assetsConsolidationsCount, $total->turnover);
        $this->assertEquals($trading_cost / $assetsConsolidationsCount, $total->trading_cost);
        $this->assertEquals($management_expense / $assetsConsolidationsCount, $total->management_expense);
        $this->assertEquals($wrap_fee / $assetsConsolidationsCount, $total->wrap_fee);

        $totalTotalCost         = 0;
        $totalPercentOfHoldings = 0;
        /** @var OutputAssetsConsolidationsTransporter $value */
        foreach ($calculated as $value) {
            /** @psalm-suppress PossiblyNullOperand */
            $percentOdHoldings = $value->amount / $totalAmount;
            $totalPercentOfHoldings += $percentOdHoldings;
            /** @psalm-suppress PossiblyNullOperand */
            $this->assertEquals($percentOdHoldings, $value->percent_of_holdings);
            /** @psalm-suppress PossiblyNullOperand */
            $totalCost = ($value->management_expense * $value->amount) +
                ($value->wrap_fee * $value->amount)                    +
                (($value->turnover * $value->amount) * $value->trading_cost);
            $totalTotalCost += $totalCost;
            /** @psalm-suppress PossiblyNullOperand */
            $this->assertEquals($totalCost, $value->total_cost);
            /** @psalm-suppress PossiblyNullOperand */
            $this->assertEquals($totalCost / $value->amount, $value->total_cost_percent);
        }

        $this->assertEquals($totalTotalCost, $total->total_cost);
        $this->assertEquals($totalTotalCost / $totalAmount, $total->total_cost_percent);
        $this->assertEquals($totalPercentOfHoldings, $total->percent_of_holdings);
    }
}
