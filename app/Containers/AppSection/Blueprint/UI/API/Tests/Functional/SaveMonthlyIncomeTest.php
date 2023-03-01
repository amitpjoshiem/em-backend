<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Tests\Functional;

use App\Containers\AppSection\Blueprint\Tests\ApiTestCase;
use App\Containers\AppSection\Member\Models\Member;
use App\Containers\AppSection\User\Models\User;

class SaveMonthlyIncomeTest extends ApiTestCase
{
    protected string $endpoint = 'post@v1/blueprint/monthly_income/{member_id}';

    /**
     * @test
     */
    public function testSaveEmptyMonthlyIncome(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member   = $this->registerMember($user->getKey());
        $response = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall();
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data       = $content['data'];
        $exceptKeys = [
            'total',
            'monthly_expenses',
            'created_at',
            'updated_at',
        ];
        foreach ($data as $name => $value) {
            if (\in_array($name, $exceptKeys, true)) {
                continue;
            }

            $this->assertEquals(null, $value);
        }

        $this->assertEquals(0, $data['total']);
        $this->assertEquals(0, $data['monthly_expenses']);
        $this->assertDatabaseHas('blueprint_monthly_incomes', [
            'member_id'     => $member->getKey(),
        ]);
    }

    /**
     * @test
     */
    public function testSaveMonthlyIncome(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member       = $this->registerMember($user->getKey());
        $inputData    = $this->getMonthlyIncomeData();
        $inputStrings = array_map(fn ($item): string => (string)$item, $inputData);
        $response     = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall($inputStrings);
        $response->assertSuccessful();

        $content = $response->getOriginalContent();
        $this->assertArrayHasKey('data', $content);
        $data       = $content['data'];
        $exceptKeys = [
            'total',
            'monthly_expenses',
            'created_at',
            'updated_at',
        ];
        foreach ($data as $name => $value) {
            if (\in_array($name, $exceptKeys, true)) {
                continue;
            }

            $this->assertEquals($inputData[$name], $value);
        }

        $this->assertDatabaseHas('blueprint_monthly_incomes', array_merge(['member_id' => $member->getKey()], $inputData));
        $this->assertEquals(
            $this->calculateTotal($inputData),
            $data['total']
        );
        $this->assertEquals(
            $this->calculateMonthlyExpenses($inputData),
            $data['monthly_expenses']
        );
    }

    /**
     * @test
     */
    public function saveIncorrectMonthlyIncome(): void
    {
        /** @var User $user */
        $user = $this->getTestingUser();
        /** @var Member $member */
        $member                 = $this->registerMember($user->getKey());
        $data                   = $this->getMonthlyIncomeData();
        $data['current_member'] = $this->faker->word();
        $response               = $this->injectId($member->getKey(), replace: '{member_id}')->makeCall($data);
        $response->assertStatus(422);
        $this->assertResponseContainKeyValue([
            'message' => 'The given data was invalid.',
        ]);

        $response->assertJsonValidationErrors([
            'current_member'        => 'The current member must be a number.',
            'current_spouse'        => 'The current spouse must be a string.',
            'current_pensions'      => 'The current pensions must be a string.',
            'current_rental_income' => 'The current rental income must be a string.',
            'current_investment'    => 'The current investment must be a string.',
            'future_member'         => 'The future member must be a string.',
            'future_spouse'         => 'The future spouse must be a string.',
            'future_pensions'       => 'The future pensions must be a string.',
            'future_rental_income'  => 'The future rental income must be a string.',
            'future_investment'     => 'The future investment must be a string.',
            'tax'                   => 'The tax must be a string.',
            'ira_first'             => 'The ira first must be a string.',
            'ira_second'            => 'The ira second must be a string.',
        ]);
    }
}
