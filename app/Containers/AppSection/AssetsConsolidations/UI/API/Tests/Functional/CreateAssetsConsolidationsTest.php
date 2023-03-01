<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Tests\Functional;

use App\Containers\AppSection\AssetsConsolidations\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class CreateAssetsConsolidationsTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/assets_consolidations/{member_id}';

    /**
     * @test
     */
    public function testCreateAssetsConsolidations(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();

        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();

        $response->assertSuccessful();

        $content = $response->getOriginalContent();

        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertDatabaseHas('assets_consolidations', [
            'member_id'             => $member->getKey(),
            'name'                  => null,
            'amount'                => null,
            'management_expense'    => null,
            'turnover'              => null,
            'trading_cost'          => null,
            'wrap_fee'              => null,
        ]);

        $this->assertCount(2, $data);
        $total = end($data);
        $this->assertEmpty(array_diff([
            'id'                    => 'total',
            'name'                  => 'total',
            'percent_of_holdings'   => '0',
            'amount'                => '0',
            'management_expense'    => null,
            'turnover'              => null,
            'trading_cost'          => null,
            'wrap_fee'              => null,
            'total_cost_percent'    => '0',
            'total_cost'            => '0',
        ], $total));
    }
}
