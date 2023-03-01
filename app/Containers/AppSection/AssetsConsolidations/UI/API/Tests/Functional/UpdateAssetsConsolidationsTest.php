<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Containers\AppSection\AssetsConsolidations\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class UpdateAssetsConsolidationsTest extends ApiTestCase
{
    protected string $endpoint = 'patch@v1/assets_consolidations/{id}';

    /**
     * @test
     */
    public function testUpdateAssetsConsolidations(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        /** @var AssetsConsolidationsTable $table */
        $table = AssetsConsolidationsTable::factory()->create([
            'member_id' => $member->getKey(),
        ]);
        $assetsConsolidation = AssetsConsolidations::factory()->create([
            'member_id'     => $member->getKey(),
            'table_id'      => $table->getKey(),
        ]);

        $assetsConsolidationData = array_map(fn ($item): string => (string)$item, AssetsConsolidations::factory()->make()->toArray());

        $response = $this->injectId($assetsConsolidation->getKey())->makeCall($assetsConsolidationData);

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);

        $this->assertDatabaseHas('assets_consolidations', array_merge($this->convertFromPercents($assetsConsolidationData), [
            'member_id' => $member->getKey(),
        ]));
    }
}
