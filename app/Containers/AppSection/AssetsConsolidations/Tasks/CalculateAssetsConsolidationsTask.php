<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTableTransporter;
use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\OutputAssetsConsolidationsTransporter;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Collection;

class CalculateAssetsConsolidationsTask extends Task
{
    private Collection $totalTable;

    public function run(EloquentCollection $assetsConsolidations): Collection
    {
        $this->totalTable = new Collection();
        $result           = new Collection();
        foreach ($assetsConsolidations->groupBy('table_id') as $table => $tableData) {
            /** @var AssetsConsolidationsTable $table */
            $table = app(GetAssetsConsolidationsTableTask::class)->run($table);

            $tableTransporter = new OutputAssetsConsolidationsTableTransporter([
                'tableHashId' => $table->getHashedKey(),
                'name'        => $table->name,
                'wrap_fee'    => $table->wrap_fee,
                'tableData'   => $this->calculateTable($tableData),
            ]);
            $result->add($tableTransporter);
        }

        $table = new OutputAssetsConsolidationsTableTransporter([
            'tableHashId' => 'total',
            'name'        => 'total',
            'tableData'   => $this->calculateTotalTable(),
        ]);

        $result->add($table);

        return $result;
    }

    private function calculateTotalTable(): Collection
    {
        $data = new EloquentCollection();
        /** @var OutputAssetsConsolidationsTransporter $row */
        foreach ($this->totalTable as $row) {
            $tableRow = new AssetsConsolidations();
            $tableRow->fill([
                'name'               => $row->table['name'] ?? null,
                'amount'             => $row->amount,
                'management_expense' => $row->management_expense,
                'turnover'           => $row->turnover,
                'trading_cost'       => $row->trading_cost,
                'wrap_fee'           => $row->wrap_fee,
            ]);
            $data->add($tableRow);
        }

        return $this->calculateTable($data);
    }

    public function calculateTable(EloquentCollection $tableData): Collection
    {
        $result      = new Collection();
        $totalAmount = $tableData->sum('amount');
        /** @var AssetsConsolidations $firstRow */
        $firstRow = $tableData->first();
        /** @var AssetsConsolidations $assetsConsolidation */
        foreach ($tableData as $assetsConsolidation) {
            $totalCost = $this->calculateTotalCost($assetsConsolidation);

            $totalCostPercent  = empty($assetsConsolidation->amount) ? 0 : $totalCost   / $assetsConsolidation->amount;
            $percentOfHoldings = empty($totalAmount) ? 0 : $assetsConsolidation->amount / $totalAmount;

            $result->add(new OutputAssetsConsolidationsTransporter(array_merge(
                $assetsConsolidation->toArray(),
                [
                    'percent_of_holdings' => $percentOfHoldings,
                    'total_cost_percent'  => $totalCostPercent,
                    'total_cost'          => $totalCost,
                    'hashId'              => $assetsConsolidation->getHashedKey(),
                ]
            )));
        }

        $totalCost = $result->sum('total_cost');

        $totalCostPercent = empty($totalAmount) ? 0 : $totalCost / $totalAmount;

        $total = new OutputAssetsConsolidationsTransporter([
            'hashId'              => 'total',
            'name'                => 'total',
            'percent_of_holdings' => $result->sum('percent_of_holdings'),
            'amount'              => $totalAmount,
            'management_expense'  => $result->avg('management_expense'),
            'turnover'            => $result->avg('turnover'),
            'trading_cost'        => $result->avg('trading_cost'),
            'wrap_fee'            => $result->avg('wrap_fee'),
            'total_cost_percent'  => $totalCostPercent,
            'total_cost'          => $totalCost,
            'table'               => $firstRow->table?->toArray(),
        ]);
        $result->add($total);
        $total       = clone $total;
        $total->name = null;
        $this->totalTable->add($total);

        return $result;
    }

    private function calculateTotalCost(AssetsConsolidations $assetsConsolidation): float
    {
        return (float)(
            ($assetsConsolidation->management_expense * $assetsConsolidation->amount) +
            ($assetsConsolidation->wrap_fee * $assetsConsolidation->amount) +
            (($assetsConsolidation->turnover * $assetsConsolidation->amount) * $assetsConsolidation->trading_cost)
        );
    }
}
