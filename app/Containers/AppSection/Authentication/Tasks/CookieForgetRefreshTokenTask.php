<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Cookie\CookieJar;
use Symfony\Component\HttpFoundation\Cookie;

class CookieForgetRefreshTokenTask extends Task
{
    /**
     * @param string      $name
     * @param string|null $path
     * @param string|null $domain
     * @param bool|null   $secure
     * @param bool        $httpOnly
     * @param bool        $raw
     * @param string|null $sameSite
     */
    public function run(CookieJar $cookie, $name = 'refreshToken', $path = null, $domain = null, $secure = null, $httpOnly = true, $raw = false, $sameSite = null): Cookie
    {
        return $cookie->make($name, '', -2_628_000, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
    }
}
