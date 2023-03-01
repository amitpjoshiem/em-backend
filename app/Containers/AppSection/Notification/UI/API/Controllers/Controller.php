<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Notification\UI\API\Controllers;

use App\Containers\AppSection\Notification\Actions\GenerateTestNotification;
use App\Containers\AppSection\Notification\Actions\GetNotificationChannel;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function getNotificationChannel(): JsonResponse
    {
        $channel = app(GetNotificationChannel::class)->run();

        return $this->json($channel);
    }

    public function generateTestNotification(): JsonResponse
    {
        app(GenerateTestNotification::class)->run();

        return $this->noContent();
    }
}
