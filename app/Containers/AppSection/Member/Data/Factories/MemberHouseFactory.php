<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Factories;

use App\Containers\AppSection\Member\Models\MemberHouse;
use App\Ship\Parents\Factories\Factory;

class MemberHouseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberHouse::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type'                      => $this->faker->randomElement([MemberHouse::OWN, MemberHouse::RENT, MemberHouse::FAMILY]),
            'market_value'              => (string)$this->faker->randomFloat(3, 50000, 999999),
            'total_debt'                => (string)$this->faker->randomFloat(3, 1000, 50000),
            'remaining_mortgage_amount' => (string)$this->faker->randomFloat(3, 1000, 20000),
            'monthly_payment'           => (string)$this->faker->randomFloat(3, 200, 2000),
            'total_monthly_expenses'    => (string)$this->faker->randomFloat(3, 200, 3000),
        ];
    }
}
