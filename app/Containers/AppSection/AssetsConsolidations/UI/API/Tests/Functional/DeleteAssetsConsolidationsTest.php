<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class DeleteAssetsConsolidationsTest extends ApiTestCase
{
    protected string $endpoint = 'delete@v1/assets_consolidations/{id}';

    /**
     * @test
     */
    public function testDeleteAssetsConsolidations(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $assetsConsolidation = AssetsConsolidations::factory()->create([
            'member_id'     => $member->getKey(),
        ]);

        $response = $this->injectId($assetsConsolidation->getKey())->makeCall();

        $response->assertSuccessful();

        $this->assertDatabaseMissing('assets_consolidations', [
            'id' => $assetsConsolidation->getKey(),
        ]);
    }
}
