<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Middlewares;

use App\Containers\AppSection\Otp\Models\OtpSecurity;
use App\Containers\AppSection\Otp\Services\EmailOtpService;
use App\Containers\AppSection\Otp\Tasks\GetUserOtpSecurityTask;
use App\Containers\AppSection\User\Actions\FindUserByEmailAction;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OtpLogin extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param string|null ...$guards
     *
     * @return JsonResponse
     *
     * @throws UserNotFoundException
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        /** @var JsonResponse $response */
        $response = $next($request);

        $email = $request->get('email');

        if ($email === null) {
            throw new UserNotFoundException();
        }

        /** @var User $user */
        $user = app(FindUserByEmailAction::class)->run($email);

        /** @var OtpSecurity | null $otpSecurity */
        $otpSecurity = app(GetUserOtpSecurityTask::class)->run($user->getKey());

        $otpServices = array_flip(config('appSection-otp.otp_services'));

        $service = $otpServices[EmailOtpService::class];

        if ($otpSecurity !== null && isset($otpServices[$otpSecurity->service_type])) {
            $service = $otpServices[$otpSecurity->service_type];
        }

        $response->header('X-Otp-Type', $service);
        $response->header('X-Otp-Enabled', $this->getBooleanHeader($otpSecurity?->enabled));
        $response->header('Access-Control-Expose-Headers', ['X-Otp-Type', 'X-Otp-Enabled']);

        return $response;
    }

    private function getBooleanHeader(?bool $value): string
    {
        if ($value === null) {
            return 'true';
        }

        return $value ? 'true' : 'false';
    }
}
