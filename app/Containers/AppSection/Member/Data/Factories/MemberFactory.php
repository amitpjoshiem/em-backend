<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Factories;

use App\Containers\AppSection\Member\Data\Enums\MemberStepsEnum;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Factories\Factory;

class MemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Member::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $retired = $this->faker->boolean();
        $type    = $this->faker->randomElement([Member::PROSPECT, Member::CLIENT, Member::LEAD, Member::PRE_LEAD]);

        /** @psalm-suppress UndefinedMagicMethod */
        return [
            'name'              => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'retired'           => $retired,
            'retirement_date'   => $retired ? $this->faker->dateTimeBetween('-10 years')->format('Y-m-d') : null,
            'married'           => $this->faker->boolean(),
            'type'              => $type,
            'email'             => $this->faker->email(),
            'phone'             => $this->faker->numerify('(###) ###-####'),
            'birthday'          => $this->faker->dateTimeBetween('-99 years', '-30 years')->format('Y-m-d'),
            'address'           => $this->faker->address(),
            'city'              => $this->faker->city(),
            'state'             => $this->faker->state(),
            'zip'               => (string)$this->faker->randomNumber(5, true),
            'step'              => $type === Member::LEAD ? $this->faker->randomElement(\array_slice(MemberStepsEnum::values(), 0, 4)) : $this->faker->randomElement(MemberStepsEnum::values()),
            'notes'             => $this->faker->realText(),
            'created_at'        => $this->faker->dateTimeBetween('-1 years')->format('Y-m-d'),
        ];
    }
}
