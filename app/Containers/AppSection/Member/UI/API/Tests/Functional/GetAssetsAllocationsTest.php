<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Models\MemberAssetAllocation;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class GetAssetsAllocationsTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/asset_allocation/{member_id}';

    /**
     * @test
     */
    public function getFirstAssetAllocationTest(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertStatus(200);

        $content = $response->getOriginalContent();
        $this->assertIsArray($content);
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertDatabaseHas('member_asset_allocations', [
            'member_id'     => $member->getKey(),
            'liquidity'     => $data['liquidity'],
            'growth'        => $data['growth'],
            'income'        => $data['income'],
        ]);
        $this->assertArrayHasKey('total', $data);
        $this->assertEquals(0, $data['total']);
    }

    /**
     * @test
     */
    public function getAssetAllocationAfterSaveTest(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        /** @var MemberAssetAllocation $assetsAllocation */
        $assetsAllocation = MemberAssetAllocation::factory()->create([
            'member_id' => $member->getKey(),
        ]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertStatus(200);

        $content = $response->getOriginalContent();
        $this->assertIsArray($content);
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertDatabaseHas('member_asset_allocations', [
            'member_id'     => $member->getKey(),
            'liquidity'     => $data['liquidity'],
            'growth'        => $data['growth'],
            'income'        => $data['income'],
        ]);
        $this->assertArrayHasKey('total', $data);
        $income    = $assetsAllocation->income    ?? 0;
        $growth    = $assetsAllocation->growth    ?? 0;
        $liquidity = $assetsAllocation->liquidity ?? 0;
        $this->assertEquals(
            round($income + $growth + $liquidity, 3),
            $data['total']
        );
    }

    /**
     * @test
     */
    public function getWithoutMemberIdTest(): void
    {
        $this->getTestingUser();
        $response = $this->makeCall();
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
        $response->assertJsonValidationErrors([
            'member_id' => 'The member id field is required.',
        ]);
    }
}
