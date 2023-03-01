<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Models\BlueprintMonthlyIncome;
use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Support\Arr;

class GetMonthlyIncomeTest extends ApiTestCase
{
    protected string $endpoint = 'get@v1/blueprint/monthly_income/{member_id}';

    /**
     * @test
     */
    public function testGetMonthlyIncome(): void
    {
        /** @var User $user */
        $user          = $this->getTestingUser();
        $member        = $this->registerMember($user->getKey());
        $monthlyIncome = BlueprintMonthlyIncome::factory()->create(['member_id' => $member->getKey()]);

        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data = $content['data'];
        $this->assertEquals($this->calculateMonthlyExpenses($data), $data['monthly_expenses']);
        $this->assertEquals($this->calculateTotal($data), $data['total']);
        unset($data['total'], $data['monthly_expenses']);

        $inputData = Arr::except($monthlyIncome->toArray(), ['id', 'member_id']);

        $this->assertEmpty(array_diff($inputData, $data));
    }
}
