<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Factories;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidations;
use App\Ship\Parents\Factories\Factory;

class AssetsConsolidationsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AssetsConsolidations::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'                  => $this->faker->sentence(),
            'amount'                => $this->faker->randomFloat(3, 99, 999999),
            'management_expense'    => $this->faker->randomFloat(2, 0, 100) / 100,
            'turnover'              => $this->faker->randomFloat(2, 0, 100) / 100,
            'trading_cost'          => $this->faker->randomFloat(2, 0, 100) / 100,
            'wrap_fee'              => $this->faker->randomFloat(2, 0, 100) / 100,
        ];
    }
}
