<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;

class GetNetWorthTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/blueprint/networth/{member_id}';

    /**
     * @test
     */
    public function testGetNetWorth(): void
    {
        /** @var User $user */
        $user   = $this->getTestingUser();
        $member = $this->registerMember($user->getKey());
        /** @var BlueprintNetworth $netWorth */
        $netWorth = BlueprintNetworth::factory()->create(['member_id' => $member->getKey()]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data                = $content['data'];
        $market              = $netWorth->market      ?? 0;
        $liquid              = $netWorth->liquid      ?? 0;
        $income_safe         = $netWorth->income_safe ?? 0;
        $total               = $market + $liquid + $income_safe;
        $market_percent      = round($market / $total * 100, 2);
        $liquid_percent      = round($liquid / $total * 100, 2);
        $income_safe_percent = round($income_safe / $total * 100, 2);
        $this->assertEquals($total, $data['total']);
        $this->assertEquals($netWorth->market, $data['market']['amount']);
        $this->assertEquals($netWorth->liquid, $data['liquid']['amount']);
        $this->assertEquals($netWorth->income_safe, $data['income_safe']['amount']);
        $this->assertEquals($market_percent, $data['market']['percent']);
        $this->assertEquals($liquid_percent, $data['liquid']['percent']);
        $this->assertEquals($income_safe_percent, $data['income_safe']['percent']);
    }

    public function testGetEmptyNetWorth(): void
    {
        /** @var User $user */
        $user   = $this->getTestingUser();
        $member = $this->registerMember($user->getKey());

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertEquals(0, $data['total']);
        unset($data['total']);
        $outputData = [
            'market' => [
                'amount'    => null,
                'percent'   => 0,
            ],
            'liquid' => [
                'amount'    => null,
                'percent'   => 0,
            ],
            'income_safe' => [
                'amount'    => null,
                'percent'   => 0,
            ],
        ];
        foreach ($data as $name => $value) {
            $this->assertEmpty(array_diff($value, $outputData[$name]));
        }
    }
}
