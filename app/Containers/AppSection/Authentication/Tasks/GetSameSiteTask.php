<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GetSameSiteTask extends Task
{
    public function __construct(private Request $request)
    {
    }

    public function run(): string
    {
        $origin = $this->request->header('origin');
        $origin = \is_string($origin) ? $origin : '';

        $isAllowedHost = Str::contains($origin, config('appSection-authentication.cookie.is-allowed-host'));

        return $isAllowedHost ? config('appSection-authentication.cookie.policy-for-host') : config('session.same_site');
    }
}
