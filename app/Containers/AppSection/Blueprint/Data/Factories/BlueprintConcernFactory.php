<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\Data\Factories;

use App\Containers\AppSection\Blueprint\Models\BlueprintConcern;
use App\Ship\Parents\Factories\Factory;

class BlueprintConcernFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlueprintConcern::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'high_fees'                                     => $this->faker->boolean(),
            'extremely_high_market_exposure'                => $this->faker->boolean(),
            'simple'                                        => $this->faker->boolean(),
            'keep_the_money_safe'                           => $this->faker->boolean(),
            'massive_overlap'                               => $this->faker->boolean(),
            'design_implement_monitoring_income_strategy'   => $this->faker->boolean(),
        ];
    }
}
