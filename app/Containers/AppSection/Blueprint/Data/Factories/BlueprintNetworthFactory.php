<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Factories;

use App\Containers\AppSection\Blueprint\Models\BlueprintNetworth;
use App\Ship\Parents\Factories\Factory;

class BlueprintNetworthFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlueprintNetworth::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'market'        => $this->faker->randomFloat(3, max: 9_999_999),
            'liquid'        => $this->faker->randomFloat(3, max: 9_999_999),
            'income_safe'   => $this->faker->randomFloat(3, max: 9_999_999),
        ];
    }
}
