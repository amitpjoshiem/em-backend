<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Factories;

use App\Containers\AppSection\Authorization\Models\Permission;
use App\Ship\Parents\Factories\Factory;

class PermissionFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Permission::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug(),
        ];
    }
}
