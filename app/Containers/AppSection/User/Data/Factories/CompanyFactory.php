<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Factories;

use App\Containers\AppSection\User\Models\Company;
use App\Ship\Parents\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name'   => $this->faker->company(),
            'domain' => $this->faker->domainName(),
        ];
    }
}
