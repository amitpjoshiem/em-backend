<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Factories;

use App\Containers\AppSection\Member\Models\MemberOther;
use App\Ship\Parents\Factories\Factory;

class MemberOtherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberOther::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'risk' => $this->faker->randomElement([
                MemberOther::AGGRESSIVE,
                MemberOther::CONSERVATIVE,
                MemberOther::MODERATE,
                MemberOther::MODERATELY_AGGRESSIVE,
                MemberOther::MODERATELY_CONSERVATIVE,
            ]),
            'questions'         => $this->faker->realText(),
            'retirement'        => $this->faker->realText(),
            'retirement_money'  => $this->faker->realText(),
            'work_with_advisor' => $this->faker->boolean(),
        ];
    }
}
