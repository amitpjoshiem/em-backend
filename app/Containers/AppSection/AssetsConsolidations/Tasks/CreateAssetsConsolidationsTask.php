<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Tasks;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Ship\Parents\Tasks\Task;

class CreateAssetsConsolidationsTask extends Task
{
    public int $count;

    public function __construct()
    {
    }

    public function run(int $member_id, AssetsConsolidationsTable $table): void
    {
        $emptyAssetConsolidation = new AssetsConsolidations();
        AssetsConsolidations::factory()->create(array_merge(
            $emptyAssetConsolidation->toArray(),
            [
                'member_id'    => $member_id,
                'table_id'     => $table->getKey(),
                'wrap_fee'     => $table->wrap_fee,
            ]
        ));
    }

    public function count(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
