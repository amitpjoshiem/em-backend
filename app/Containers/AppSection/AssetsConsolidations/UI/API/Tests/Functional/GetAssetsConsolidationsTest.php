<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Containers\AppSection\AssetsConsolidations\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class GetAssetsConsolidationsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/assets_consolidations/{member_id}';

    /**
     * @test
     */
    public function testGetAssetsConsolidations(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $assetsConsolidationsCount = 5;

        AssetsConsolidations::factory()->count($assetsConsolidationsCount)->create([
            'member_id' => $member->getKey(),
        ]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);
        $data  = $content['data'];
        $total = array_pop($data);

        $this->assertEquals('total', $total['id']);
        $this->assertEquals('total', $total['name']);
        $this->assertCount($assetsConsolidationsCount, $data);
    }
}
