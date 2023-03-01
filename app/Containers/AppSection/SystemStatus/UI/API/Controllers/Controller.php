<?php

declare(strict_types=1);

namespace App\Containers\AppSection\SystemStatus\UI\API\Controllers;

use App\Containers\AppSection\SystemStatus\Actions\FallbackRouteNotFoundAction;
use App\Containers\AppSection\SystemStatus\Actions\GetAllSystemStatusesAction;
use App\Containers\AppSection\SystemStatus\Actions\GetPartnersHealthcheckAction;
use App\Containers\AppSection\SystemStatus\UI\API\Requests\GetAllSystemStatusesRequest;
use App\Containers\AppSection\SystemStatus\UI\API\Transformers\PartnersHealthcheckTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function getAllSystemStatuses(GetAllSystemStatusesRequest $request): JsonResponse
    {
        app(GetAllSystemStatusesAction::class)->run();

        return $this->json([
            'message' => 'OK',
        ]);
    }

    public function fallbackRouteNotFound(): void
    {
        app(FallbackRouteNotFoundAction::class)->run();
    }

    public function getPartnersHealthcheck(): array
    {
        $healthcheck = app(GetPartnersHealthcheckAction::class)->run();

        return $this->transform($healthcheck, PartnersHealthcheckTransformer::class, resourceKey: 'healthcheck');
    }
}
