<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetStrictlyAuthenticatedUserTask;
use App\Containers\AppSection\User\Data\Transporters\VerifyPhoneTransporter;
use App\Containers\AppSection\User\Exceptions\PhoneVerifyCodeException;
use App\Containers\AppSection\User\Exceptions\PhoneVerifyCodeExpiredException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Ship\Parents\Actions\Action;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class VerifyPhoneAction extends Action
{
    public function run(VerifyPhoneTransporter $input): void
    {
        /** @var User $user */
        $user = app(GetStrictlyAuthenticatedUserTask::class)->run();

        if ($user->phone === null) {
            throw new PhoneVerifyCodeException();
        }

        $key = sprintf(config('appSection-user.phone_code_cache_key'), $user->phone);

        if (!Cache::has($key)) {
            throw new PhoneVerifyCodeExpiredException();
        }

        $code = Cache::get($key);

        if ($code !== $input->code) {
            throw new PhoneVerifyCodeException();
        }

        app(UpdateUserTask::class)->run([
            'phone_verified_at' => Carbon::now(),
        ], $user->getKey());
    }
}
