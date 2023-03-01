<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Tasks;

use App\Containers\AppSection\Otp\Models\Otp;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

class CreateOtpCookieTask extends Task
{
    public function run(Otp $otp, string $sameSite): SymfonyCookie
    {
        /** @noRector \Rector\Php70\Rector\StaticCall\StaticCallOnNonStaticToInstanceCallRector */
        return Cookie::make(
            config('appSection-otp.otp_cookie_name'),
            $otp->external_token,
            $otp->expires_at->diffInMinutes(),
            config('session.path'),
            config('session.domain'),
            config('session.secure'),
            config('session.http_only'),
            config('session.raw'),
            $sameSite,
        );
    }
}
