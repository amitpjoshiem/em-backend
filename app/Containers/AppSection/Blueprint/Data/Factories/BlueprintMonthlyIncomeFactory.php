<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Factories;

use App\Containers\AppSection\Blueprint\Models\BlueprintMonthlyIncome;
use App\Ship\Parents\Factories\Factory;

class BlueprintMonthlyIncomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlueprintMonthlyIncome::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'current_member'        => $this->faker->randomFloat(3, max: 9_999_999),
            'current_spouse'        => $this->faker->randomFloat(3, max: 9_999_999),
            'current_pensions'      => $this->faker->randomFloat(3, max: 9_999_999),
            'current_rental_income' => $this->faker->randomFloat(3, max: 9_999_999),
            'current_investment'    => $this->faker->randomFloat(3, max: 9_999_999),
            'future_member'         => $this->faker->randomFloat(3, max: 9_999_999),
            'future_spouse'         => $this->faker->randomFloat(3, max: 9_999_999),
            'future_pensions'       => $this->faker->randomFloat(3, max: 9_999_999),
            'future_rental_income'  => $this->faker->randomFloat(3, max: 9_999_999),
            'future_investment'     => $this->faker->randomFloat(3, max: 9_999_999),
            'tax'                   => $this->faker->randomFloat(3, max: 9_999_999),
            'ira_first'             => $this->faker->randomFloat(3, max: 9_999_999),
            'ira_second'            => $this->faker->randomFloat(3, max: 9_999_999),
        ];
    }
}
