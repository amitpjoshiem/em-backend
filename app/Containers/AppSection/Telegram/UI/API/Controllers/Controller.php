<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Telegram\UI\API\Controllers;

use App\Containers\AppSection\Telegram\Actions\LoginTelegramAction;
use App\Containers\AppSection\Telegram\UI\API\Requests\LoginTelegramRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function loginTelegram(LoginTelegramRequest $request): JsonResponse
    {
        app(LoginTelegramAction::class)->run($request->toTransporter());

        return $this->noContent();
    }
}
