<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Factories;

use App\Containers\AppSection\Salesforce\Models\SalesforceOpportunity;
use App\Ship\Parents\Factories\Factory;

class SalesforceOpportunityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesforceOpportunity::class;

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
