<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Factories;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = User::class;

    public function definition(): array
    {
        static $password;

        return [
            'username'          => $this->faker->name(),
            'first_name'        => $this->faker->firstName(),
            'last_name'         => $this->faker->lastName(),
            'email'             => $this->faker->unique()->safeEmail,
            'password'          => $password ?: $password = Hash::make('testing-password'),
            'email_verified_at' => now(),
            'remember_token'    => Str::random(10),
            'is_client'         => false,
            'data_source'       => $this->faker->randomElement(array_keys(config('init-container.data_sources'))),
            'last_login_at'     => now(),
            'last_login_ip'     => $this->faker->ipv4(),
        ];
    }

    public function client(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'is_client' => true,
        ]);
    }

    public function unverified(): self
    {
        return $this->state(static fn (array $attributes): array => [
            'email_verified_at' => null,
        ]);
    }
}
