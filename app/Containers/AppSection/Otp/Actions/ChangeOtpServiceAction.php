<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Activity\Events\Events\ChangeOTPServiceEvent;
use App\Containers\AppSection\Authentication\Exceptions\AuthenticationUserException;
use App\Containers\AppSection\Authentication\Services\AuthenticatedUser;
use App\Containers\AppSection\Authentication\Tasks\GetSameSiteTask;
use App\Containers\AppSection\Otp\Data\Transporters\ChangeOtpTransporter;
use App\Containers\AppSection\Otp\Services\OtpService;
use App\Containers\AppSection\Otp\Tasks\ChangeUserOtpSecretTask;
use App\Containers\AppSection\Otp\Tasks\CreateOtpCookieTask;
use App\Containers\AppSection\Otp\Tasks\DisableUserOtpTask;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Actions\Action;
use Symfony\Component\HttpFoundation\Cookie;

class ChangeOtpServiceAction extends Action
{
    public function __construct(protected AuthenticatedUser $authenticatedUser)
    {
    }

    /**
     * @throws AuthenticationUserException
     */
    public function run(ChangeOtpTransporter $input): ?Cookie
    {
        /** @var User $user */
        $user = $this->authenticatedUser->getStrictlyAuthUserModel();

        if ($input->service === null) {
            app(DisableUserOtpTask::class)->run($user->getKey());

            return null;
        }

        $configServices = config('appSection-otp.otp_services');
        /** @var OtpService $service */
        $service = new $configServices[$input->service]();

        $service->changeOtp($user, $input->code);

        app(ChangeUserOtpSecretTask::class)->run($user->getKey(), $service);

        event(new ChangeOTPServiceEvent($user->getKey(), $input->service));

        $sameSite = app(GetSameSiteTask::class)->run();

        $otp = app(CreateOtpSubAction::class)->run($user);

        return app(CreateOtpCookieTask::class)->run($otp, $sameSite);
    }
}
