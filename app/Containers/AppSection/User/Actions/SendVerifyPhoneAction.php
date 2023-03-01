<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\Sms\Notifications\SmsNotification;
use App\Containers\AppSection\User\Data\Transporters\SendVerifyPhoneTransporter;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class SendVerifyPhoneAction extends Action
{
    public function run(SendVerifyPhoneTransporter $input): void
    {
        $key = sprintf(config('appSection-user.phone_code_cache_key'), $input->phone);

        $code = Cache::remember($key, Carbon::now()->addMinutes(5), function (): int {
            return random_int(100000, 999999);
        });

        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();
        app(UpdateUserTask::class)->run([
            'phone' => $input->phone,
        ], $user->getKey());
        $user->notifyNow(new SmsNotification(sprintf('Your verify code: %s', $code)));
    }
}
