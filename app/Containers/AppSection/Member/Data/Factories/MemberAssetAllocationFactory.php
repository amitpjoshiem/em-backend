<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Factories;

use App\Containers\AppSection\Member\Models\MemberAssetAllocation;
use App\Ship\Parents\Factories\Factory;

class MemberAssetAllocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberAssetAllocation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'liquidity' => $this->faker->randomFloat(3, max: 9_999_999),
            'growth'    => $this->faker->randomFloat(3, max: 9_999_999),
            'income'    => $this->faker->randomFloat(3, max: 9_999_999),
        ];
    }
}
