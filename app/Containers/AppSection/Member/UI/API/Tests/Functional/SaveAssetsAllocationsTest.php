<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Tests\Functional;

use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\Member\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class SaveAssetsAllocationsTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/asset_allocation/{member_id}';

    /**
     * @test
     */
    public function saveEmptyAssetsAllocation(): void
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
    public function saveAssetsAllocation(): void
    {
        $liquidity  = $this->faker->randomFloat(3, max: 9_999_999);
        $growth     = $this->faker->randomFloat(3, max: 9_999_999);
        $income     = $this->faker->randomFloat(3, max: 9_999_999);
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall([
            'liquidity' => (string)$liquidity,
            'growth'    => (string)$growth,
            'income'    => (string)$income,
        ]);
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
        $this->assertEquals(round($liquidity + $growth + $income, 3), $data['total']);
    }

    /**
     * @test
     */
    public function saveErrorAssetsAllocations(): void
    {
        $liquidity  = $this->faker->randomFloat(3, max: 9_999_999);
        $growth     = $this->faker->word();
        $income     = null;
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall([
            'liquidity' => $liquidity,
            'growth'    => $growth,
            'income'    => $income,
        ]);
        $response->assertStatus(422);

        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);
        $response->assertJsonValidationErrors([
            'liquidity' => 'The liquidity must be a string.',
            'growth'    => 'The growth must be a number.',
        ]);
    }

    /**
     * @test
     */
    public function saveWithoutDataTest(): void
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
