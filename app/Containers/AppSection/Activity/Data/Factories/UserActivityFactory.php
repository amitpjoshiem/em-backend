<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Data\Factories;

use App\Containers\AppSection\Activity\Events\Events\AbstractActivityEvent;
use App\Containers\AppSection\Activity\Events\Events\ChangeOTPServiceEvent;
use App\Containers\AppSection\Activity\Events\Events\ChangeOwnEmailEvent;
use App\Containers\AppSection\Activity\Events\Events\ImportMemberFromSalesforceEvent;
use App\Containers\AppSection\Activity\Events\Events\MemberChildOpportunityAddedEvent;
use App\Containers\AppSection\Activity\Events\Events\MemberUpdateBasicInfoEvent;
use App\Containers\AppSection\Activity\Events\Events\ProspectAddedEvent;
use App\Containers\AppSection\Activity\Events\Events\ProspectConvertToClientEvent;
use App\Containers\AppSection\Activity\Models\UserActivity;
use App\Ship\Parents\Factories\Factory;

class UserActivityFactory extends Factory
{
    /**
     * @var array<class-string<\App\Containers\AppSection\Activity\Events\Events\AbstractActivityEvent>>
     */
    private const ACTIVITIES = [
        ChangeOTPServiceEvent::class,
        ChangeOwnEmailEvent::class,
        ImportMemberFromSalesforceEvent::class,
        MemberChildOpportunityAddedEvent::class,
        MemberUpdateBasicInfoEvent::class,
        ProspectAddedEvent::class,
        ProspectConvertToClientEvent::class,
    ];

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserActivity::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $state  = $this->states->last()->call($this);
        $userId = $state['user_id'];
        /** @var AbstractActivityEvent $randomActivity */
        $randomActivity = $this->faker->randomElement(self::ACTIVITIES);

        return [
            'activity_data' => $randomActivity::seedActivity($this->faker, $userId),
            'activity'      => $randomActivity,
            'created_at'    => $this->faker->dateTimeBetween('-30 days'),
        ];
    }
}
