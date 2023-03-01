<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Factories;

use App\Containers\AppSection\Member\Tasks\FindMemberByIdTask;
use App\Containers\AppSection\Yodlee\Models\YodleeAccounts;
use App\Ship\Parents\Factories\Factory;

class YodleeAccountsFactory extends Factory
{
    /**
     * @var string[]
     */
    private const ACCOUNT_NAMES = [
        'TESTDATA',
        'TESTDATA1',
        'CREDIT CARD',
        'Joint Checking - 9060',
        'Joint Savings - 7159',
        'My CD - 8878',
        'CashRewardOld - 0784',
        'CMA -Joint Brokerage - 3547',
        'Retirement Savings Plan - 4258',
        'ROTH IRA - 4619',
        'Chase Mortgage - 0038',
        'Citi Automobile Loan - x1563',
        'College Loan - x8946',
        'Lendin Club personal loan - x7608',
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = YodleeAccounts::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $state    = $this->states->last()->call($this);
        $memberId = $state['member_id'];
        $member   = app(FindMemberByIdTask::class)->run($memberId);

        $createdAt = $this->faker->dateTimeBetween($member->created_at);

        return [
            'yodlee_id'             => $this->faker->unique()->numberBetween(10_000_000, 999_999_999),
            'member_id'             => $member->getKey(),
            'user_id'               => $member->user_id,
            'account_name'          => $this->faker->randomElement(self::ACCOUNT_NAMES),
            'account_status'        => 'ACTIVE',
            'balance'               => $this->faker->randomFloat(3, max: 9_999_999),
            'include_int_net_worth' => $this->faker->boolean(),
            'provider_id'           => $this->faker->randomElement([16441, 16442]),
            'provider_name'         => $this->faker->randomElement(['Dag Site', 'Dag Site Multilevel']),
            'sync_at'               => $this->faker->dateTimeBetween('-10 hours'),
            'created_at'            => $createdAt,
            'updated_at'            => $this->faker->dateTimeBetween($createdAt),
        ];
    }
}
