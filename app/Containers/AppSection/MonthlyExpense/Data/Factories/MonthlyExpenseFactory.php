<?php

declare(strict_types=1);

namespace App\Containers\AppSection\MonthlyExpense\Data\Factories;

use App\Containers\AppSection\MonthlyExpense\Models\MonthlyExpense;
use App\Ship\Parents\Factories\Factory;

class MonthlyExpenseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MonthlyExpense::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
        ];
    }
}
