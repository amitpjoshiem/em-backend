<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Guards;

use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Tasks\CheckUserOtpVerifyTask;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Ship\Parents\Models\UserModel;
use Illuminate\Contracts\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard as PassportTokenGuard;
use Laravel\Passport\Passport;
use Laravel\Passport\PassportUserProvider;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

final class TokenGuard extends PassportTokenGuard
{
    public function __construct(
        ResourceServer $server,
        PassportUserProvider $provider,
        TokenRepository $tokens,
        ClientRepository $clients,
        Encrypter $encrypter
    ) {
        parent::__construct($server, $provider, $tokens, $clients, $encrypter);
    }

    /**
     * @inheritDoc
     */
    public function user(Request $request): ?UserModel
    {
        /** @var UserModel|null $user */
        $user = null;

        /** @var string $cookie */
        $cookie = Passport::cookie();

        if ($request->bearerToken()) {
            $user = $this->authenticateViaBearerToken($request);
        } elseif ($request->cookie($cookie)) {
            $user = $this->authenticateViaCookie($request);
        }

        if ($user !== null) {
            /** @var OtpSecurity | null $otpSecurity */
            $otpSecurity = app(GetUserOtpSecurityTask::class)->run($user->getKey());

            if ($otpSecurity !== null && !$otpSecurity->enabled) {
                return $user;
            }

            /** @var Route $route */
            $route = $request->route();

            if (!\in_array($route->getName(), config('appSection-otp.skip_otp_routes'), true)) {
                $otpCheck = app(CheckUserOtpVerifyTask::class)->run($user);

                if (!$otpCheck) {
                    return null;
                }
            }
        }

        return $user;
    }
}
