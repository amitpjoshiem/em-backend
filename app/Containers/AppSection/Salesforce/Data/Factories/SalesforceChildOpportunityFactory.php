<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Factories;

use App\Containers\AppSection\Salesforce\Models\SalesforceChildOpportunity;
use App\Ship\Parents\Factories\Factory;

class SalesforceChildOpportunityFactory extends Factory
{
    /**
     * @var string[]
     */
    private const STAGES = [
        '1st Appointment',
        '2nd Appointment',
        '3rd Appointment',
        '4th (+) Appointment',
        'Placeholder Acct',
        'Paperwork Signed',
        'Commission Paid',
        'Closed Won',
        'Closed Lost',
    ];

    /**
     * @var string[]
     */
    private const TYPES = [
        'Annuity',
        'Managed Money',
        'Insurance',
        'Consulting',
        'Alternative',
        'Placeholder Acct',
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesforceChildOpportunity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'salesforce_id'             => $this->faker->md5(),
            'amount'                    => $this->faker->randomFloat(3, max: 99999),
            'salesforce_opportunity_id' => $this->faker->randomDigit(),
            'name'                      => $this->faker->sentence(),
            'type'                      => $this->faker->randomElement(self::TYPES),
            'close_date'                => $this->faker->dateTimeBetween('now', '+6 months'),
            'stage'                     => $this->faker->randomElement(self::STAGES),
            'created_at'                => $this->faker->dateTimeBetween('-1 year'),
        ];
    }
}
