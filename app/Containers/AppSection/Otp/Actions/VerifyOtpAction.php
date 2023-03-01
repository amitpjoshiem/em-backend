<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Containers\AppSection\Authentication\Tasks\GetSameSiteTask;
use App\Containers\AppSection\Otp\Data\Transporters\VerifyOtpTransporter;
use App\Containers\AppSection\Otp\Exceptions\OtpVerifyException;
use App\Containers\AppSection\Otp\Tasks\CreateOtpCookieTask;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Containers\AppSection\Otp\Tasks\RevokeAllOldUserOtpTokensTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Actions\Action;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpFoundation\Cookie;

class VerifyOtpAction extends Action
{
    public function __construct(protected AuthenticatedUser $authenticatedUser)
    {
    }

    /**
     * @throws OtpVerifyException
     * @throws CreateResourceFailedException|ValidatorException
     * @throws RepositoryException
     * @throws UpdateResourceFailedException
     * @throws AuthenticationUserException
     */
    public function run(VerifyOtpTransporter $otpData): Cookie
    {
        /** @var User $user */
        $user = $this->authenticatedUser->getStrictlyAuthUserModel();

        $sameSite        = app(GetSameSiteTask::class)->run();

        $otpSecurity = app(GetUserOtpSecurityTask::class)->run($user->id);

        $verified = $otpSecurity?->otpService?->checkOtp($user, $otpData->code);

        if (!$verified) {
            throw new OtpVerifyException();
        }

        app(RevokeAllOldUserOtpTokensTask::class)->filterByUser($user->getKey())->run();

        $otp = app(CreateOtpSubAction::class)->run($user);

        return app(CreateOtpCookieTask::class)->run($otp, $sameSite);
    }
}
