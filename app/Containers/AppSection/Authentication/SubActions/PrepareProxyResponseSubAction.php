<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\SubActions;

use App\Containers\AppSection\Authentication\Tasks\MakeRefreshCookieTask;
use App\Ship\Parents\Actions\SubAction;

class PrepareProxyResponseSubAction extends SubAction
{
    public function run(array $responseContent, string $sameSite): array
    {
        $refreshCookie = app(MakeRefreshCookieTask::class)->run($responseContent['refresh_token'], $sameSite);

        return [
            'response_content' => $responseContent,
            'refresh_cookie'   => $refreshCookie,
        ];
    }
}
