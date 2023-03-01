<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\Data\Factories;

use App\Containers\AppSection\AssetsConsolidations\Models\AssetsConsolidationsTable;
use App\Ship\Parents\Factories\Factory;

class AssetsConsolidationsTableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AssetsConsolidationsTable::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name'     => $this->faker->sentence(),
            'wrap_fee' => $this->faker->boolean() ? $this->faker->randomFloat(2, 0, 100) / 100 : null,
        ];
    }
}
