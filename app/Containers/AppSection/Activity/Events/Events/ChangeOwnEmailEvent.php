<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Activity\Events\Events;

use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use Faker\Generator;

class ChangeOwnEmailEvent extends AbstractActivityEvent
{
    public function __construct(int $userId, string $oldEmail)
    {
        $user = app(FindUserByIdTask::class)->run($userId);
        parent::__construct($userId, [
            'old_email' => $oldEmail,
            'new_email' => $user?->email,
        ]);
    }

    public static function getActivityHtmlString(array $data): string
    {
        return sprintf('<p>You have changed own email from %s to %s</p>', $data['old_email'], $data['new_email']);
    }

    public static function seedActivity(Generator $faker, int $userId): array
    {
        return [
            'old_email' => $faker->email(),
            'new_email' => $faker->email(),
        ];
    }
}
