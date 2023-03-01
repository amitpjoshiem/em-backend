<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\UI\API\Controllers;

use App\Containers\AppSection\Yodlee\Actions\CreateYodleeUserAction;
use App\Containers\AppSection\Yodlee\Actions\GetYodleeMemberAccountsAction;
use App\Containers\AppSection\Yodlee\Actions\GetYodleeMemberProvidesAction;
use App\Containers\AppSection\Yodlee\Actions\GetYodleeMemberStatusAction;
use App\Containers\AppSection\Yodlee\Actions\SendYodleeLinkAction;
use App\Containers\AppSection\Yodlee\UI\API\Requests\CreateYodleeUserRequest;
use App\Containers\AppSection\Yodlee\UI\API\Requests\GetYodleeAccountsRequest;
use App\Containers\AppSection\Yodlee\UI\API\Requests\GetYodleeProvidersRequest;
use App\Containers\AppSection\Yodlee\UI\API\Requests\GetYodleeStatusRequest;
use App\Containers\AppSection\Yodlee\UI\API\Requests\SendYodleeLinkRequest;
use App\Containers\AppSection\Yodlee\UI\API\Transformers\YodleeAccountsTransformer;
use App\Containers\AppSection\Yodlee\UI\API\Transformers\YodleeProvidersTransformer;
use App\Containers\AppSection\Yodlee\UI\API\Transformers\YodleeStatusTransformer;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function createYodleeUser(CreateYodleeUserRequest $request): JsonResponse
    {
        app(CreateYodleeUserAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function sendYodleeLink(SendYodleeLinkRequest $request): JsonResponse
    {
        app(SendYodleeLinkAction::class)->run($request->toTransporter());

        return $this->noContent();
    }

    public function getYodleeStatus(GetYodleeStatusRequest $request): array
    {
        $status = app(GetYodleeMemberStatusAction::class)->run($request->toTransporter());

        return $this->transform($status, YodleeStatusTransformer::class, resourceKey: 'status');
    }

    public function getYodleeProviders(GetYodleeProvidersRequest $request): array
    {
        $providers = app(GetYodleeMemberProvidesAction::class)->run($request->toTransporter());

        return $this->transform($providers, YodleeProvidersTransformer::class, resourceKey: 'providers');
    }

    public function getYodleeAccountsByProvider(GetYodleeAccountsRequest $request): array
    {
        $accounts = app(GetYodleeMemberAccountsAction::class)->run($request->toTransporter());

        return $this->transform($accounts, YodleeAccountsTransformer::class, resourceKey: 'accounts');
    }
}
