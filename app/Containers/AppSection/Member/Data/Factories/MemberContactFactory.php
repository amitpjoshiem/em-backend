<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Factories;

use App\Containers\AppSection\Member\Models\MemberContact;
use App\Ship\Parents\Factories\Factory;

class MemberContactFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberContact::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $retired = $this->faker->boolean();

        return [
            'retired'           => $retired,
            'retirement_date'   => $retired ? $this->faker->dateTimeBetween('-10 years')->format('Y-m-d') : null,
            'first_name'        => $this->faker->firstName(),
            'last_name'         => $this->faker->lastName(),
            'birthday'          => $this->faker->dateTimeBetween('-60 years', '-20 years')->format('Y-m-d'),
            'email'             => $this->faker->email(),
            'phone'             => $this->faker->numerify('(###) ###-####'),
            'is_spouse'         => $this->faker->boolean(),
        ];
    }
}
