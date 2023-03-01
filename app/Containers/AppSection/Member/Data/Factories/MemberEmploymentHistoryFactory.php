<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\Data\Factories;

use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use App\Ship\Parents\Factories\Factory;

class MemberEmploymentHistoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MemberEmploymentHistory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'company_name'  => $this->faker->company(),
            'occupation'    => $this->faker->jobTitle(),
            'years'         => (string)$this->faker->numberBetween(1, 10),
        ];
    }
}
