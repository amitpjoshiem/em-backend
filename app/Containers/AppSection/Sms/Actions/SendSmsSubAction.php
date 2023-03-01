<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Sms\Actions;

use App\Containers\AppSection\Sms\Exceptions\UserNotFoundException;
use App\Containers\AppSection\Sms\Exceptions\UserNotVerifyPhoneException;
use App\Containers\AppSection\Sms\Notifications\SmsNotification;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\SubAction;

class SendSmsSubAction extends SubAction
{
    /**
     * @throws UserNotFoundException
     * @throws UserNotVerifyPhoneException
     */
    public function run(int $userId, string $text): void
    {
        /** @var User | null $user */
        $user = app(FindUserByIdTask::class)->run($userId);

        if ($user === null) {
            throw new UserNotFoundException();
        }

        if ($user->phone_verified_at === null) {
            throw new UserNotVerifyPhoneException();
        }

        $user->notifyNow(new SmsNotification($text));
    }
}
