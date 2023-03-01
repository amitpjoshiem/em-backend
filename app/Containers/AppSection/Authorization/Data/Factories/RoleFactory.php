<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Factories;

use App\Containers\AppSection\Authorization\Models\Role;
use App\Ship\Parents\Factories\Factory;
use Spatie\Permission\Guard;

class RoleFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->slug(),
        ];
    }

    public function add_default_guard_name(): self
    {
        return $this->state(fn (array $attributes): array => [
            'guard_name' => Guard::getDefaultName(Role::class),
        ]);
    }
}
