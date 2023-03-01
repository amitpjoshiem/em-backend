<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Data\Factories;

use App\Containers\AppSection\Otp\Models\Otp;
use App\Ship\Parents\Factories\Factory;

class OtpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Otp::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }

    public function name(): self
    {
        return $this->state(fn (array $attributes): array => [
            'name' => $this->faker->name(),
        ]);
    }
}
