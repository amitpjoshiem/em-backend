<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Authentication\Tasks\GetSameSiteTask;
use App\Containers\AppSection\Otp\Models\Otp;
use App\Containers\AppSection\Otp\Tasks\CreateOtpCookieTask;
use App\Containers\AppSection\Otp\Tasks\GetOtpByUuidTask;
use App\Containers\AppSection\Otp\Tasks\RevokeOtpTokenTask;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Cookie;

class RefreshOtpTokenAction extends Action
{
    /**
     * @throws CreateResourceFailedException
     * @throws ValidatorException
     * @throws UserNotFoundException
     */
    public function run(string $uuid): Cookie
    {
        /** @var Otp | null $oldOtp */
        $oldOtp = app(GetOtpByUuidTask::class)->run($uuid);

        $sameSite        = app(GetSameSiteTask::class)->run();

        if ($oldOtp === null || $oldOtp->user === null) {
            throw new UserNotFoundException();
        }

        /** @var Otp $newOtp */
        $newOtp = app(CreateOtpSubAction::class)->run($oldOtp->user);

        app(RevokeOtpTokenTask::class)->run($oldOtp->getKey());

        return app(CreateOtpCookieTask::class)->run($newOtp, $sameSite);
    }
}
