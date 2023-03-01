<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\UI\API\Controllers;

use App\Containers\AppSection\Authentication\Actions\ApiLogoutAction;
use App\Containers\AppSection\Authentication\Actions\ProxyApiLoginAction;
use App\Containers\AppSection\Authentication\Actions\ProxyApiRefreshAction;
use App\Containers\AppSection\Authentication\Contracts\AuthenticatedModel;
use App\Containers\AppSection\Authentication\Exceptions\RefreshTokenMissedException;
use App\Containers\AppSection\Authentication\Tasks\CookieForgetRefreshTokenTask;
use App\Containers\AppSection\Authentication\Tasks\CreateProxyLoginTransporterTask;
use App\Containers\AppSection\Authentication\Tasks\CreateProxyRefreshTransporterTask;
use App\Containers\AppSection\Authentication\Tasks\GetSameSiteTask;
use App\Containers\AppSection\Authentication\UI\API\Requests\LoginRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\LogoutRequest;
use App\Containers\AppSection\Authentication\UI\API\Requests\RefreshRequest;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Cookie\CookieJar;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function logoutForApiClient(LogoutRequest $request, AuthenticatedModel $authUser, CookieJar $cookie): JsonResponse
    {
        app(ApiLogoutAction::class)->run($request->toTransporter(), $authUser->getStrictlyAuthUserId());
        $sameSite = app(GetSameSiteTask::class)->run();
        $forget   = app(CookieForgetRefreshTokenTask::class)->run($cookie, sameSite: $sameSite);

        return $this->accepted([
            'message' => 'Token revoked successfully.',
        ])->withCookie($forget);
    }

    /**
     * This `proxyLoginForApiClient` exist only because we have `ApiClient`
     * The more clients (Web Apps). Each client you add in the future, must have
     * similar functions here, with custom route for dedicated for each client
     * to be used as proxy when contacting the OAuth server.
     * This is only to help the Web Apps (JavaScript clients) hide
     * their ID's and Secrets when contacting the OAuth server and obtain Tokens.
     */
    public function proxyLoginForApiClient(LoginRequest $request): JsonResponse
    {
        $dataTransporter = app(CreateProxyLoginTransporterTask::class)->run($request->toTransporter());
        $result          = app(ProxyApiLoginAction::class)->run($dataTransporter);

        return $this->json($result['response_content'])->withCookie($result['refresh_cookie']);
    }

    /**
     * Read the comment in the function `proxyLoginForApiClient`.
     *
     * @throws RefreshTokenMissedException
     */
    public function proxyRefreshForApiClient(RefreshRequest $request): JsonResponse
    {
        $dataTransporter = app(CreateProxyRefreshTransporterTask::class)->run($request->toTransporter());
        $result          = app(ProxyApiRefreshAction::class)->run($dataTransporter);

        return $this->json($result['response_content'])->withCookie($result['refresh_cookie']);
    }
}
