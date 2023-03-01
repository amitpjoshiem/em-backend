<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;

class MakeRefreshCookieTask extends Task
{
    /**
     * @link https://www.chromestatus.com/feature/5633521622188032
     */
    public function run(?string $refreshToken, string $sameSite): Cookie | CookieJar
    {
        // Save the refresh token in a HttpOnly cookie to minimize the risk of XSS attacks
        return cookie(
            'refreshToken',
            $refreshToken,
            config('apiato.api.refresh-expires-in'),
            config('session.path'),
            config('session.domain'),
            config('session.secure'),
            config('session.http_only'),
            config('session.raw'),
            $sameSite,
        );
    }
}
