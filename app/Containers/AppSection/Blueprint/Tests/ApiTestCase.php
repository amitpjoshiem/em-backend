<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Tests;

use App\Containers\AppSection\Member\Tests\Traits\RegisterMemberTestTrait;

/**
 * Class ApiTestCase.
 *
 * This is the container API TestCase class. Use this class to add your container specific API related helper functions.
 */
class ApiTestCase extends TestCase
{
    use RegisterMemberTestTrait;

    protected function getMonthlyIncomeData(): array
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

    protected function calculateTotal(array $data): float
    {
        $totalKeys = [
            'current_member',
            'current_spouse',
            'current_pensions',
            'current_rental_income',
            'current_investment',
            'future_member',
            'future_spouse',
            'future_pensions',
            'future_rental_income',
            'future_investment',
        ];
        $total = 0;
        foreach ($data as $name => $value) {
            if (\in_array($name, $totalKeys, true)) {
                $total += $value;
            }
        }

        return round($total, 3);
    }

    protected function calculateMonthlyExpenses(array $data): float
    {
        $totalKeys = [
            'tax',
            'ira_first',
            'ira_second',
        ];
        $total = 0;
        foreach ($data as $name => $value) {
            if (\in_array($name, $totalKeys, true)) {
                $total += $value;
            }
        }

        return round($total, 3);
    }
}
