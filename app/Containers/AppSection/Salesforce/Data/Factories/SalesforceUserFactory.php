<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Factories;

use App\Containers\AppSection\Salesforce\Models\SalesforceUser;
use App\Ship\Parents\Factories\Factory;

class SalesforceUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesforceUser::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'salesforce_id'             => $this->faker->md5(),
        ];
    }
}
