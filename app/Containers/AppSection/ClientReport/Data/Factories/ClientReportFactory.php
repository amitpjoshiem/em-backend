<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\Data\Factories;

use App\Containers\AppSection\ClientReport\Models\ClientReport;
use App\Ship\Parents\Factories\Factory;

class ClientReportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClientReport::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'contract_number'   => $this->faker->randomFloat(0, max: 9_999_999),
            'carrier'           => $this->faker->company(),
            'current_value'     => $this->faker->randomFloat(3, max: 9_999_999),
            'surrender_value'   => $this->faker->randomFloat(3, max: 9_999_999),
            'origination_value' => $this->faker->randomFloat(3, max: 9_999_999),
            'origination_date'  => $this->faker->dateTimeBetween('-5 years'),
        ];
    }
}
