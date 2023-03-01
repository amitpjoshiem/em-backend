<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Factories;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsEnum;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Parents\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-1 year');

        $steps = [];
        foreach (ClientDocumentsEnum::values() as $step) {
            $steps[$step] = $this->faker->randomElement([Client::NOT_COMPLETED_STEP, Client::NO_DOCUMENTS_STEP, Client::COMPLETED_STEP]);
        }

        /** @psalm-suppress UndefinedMagicMethod */
        return array_merge([
            'terms_and_conditions'                                => true,
            'created_at'                                          => $createdAt,
            'consultation'                                        => null,
            'is_submit'                                           => false,
            'first_fill_info'                                     => $this->faker->dateTimeBetween($createdAt),
            'converted_from_lead'                                 => null,
            'closed_win_lost'                                     => null,
        ], $steps);
    }
}
