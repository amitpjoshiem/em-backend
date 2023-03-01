<?php

declare(strict_types=1);

use App\Containers\AppSection\Authentication\UI\API\Controllers\Controller as AuthenticationApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *      path="/refresh",
 *      tags={"OAuth2"},
 *      summary="User refresh tocken",
 *      description="If `refresh_token` is not provided the we'll try to get it from the http cookie.",
 *      @OA\RequestBody(
 *          @OA\JsonContent(
 *              @OA\Property (property="refresh_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbG..."),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned access token for User",
 *          @OA\JsonContent(
 *              @OA\Property (property="token_type", type="string", example="Bearer"),
 *              @OA\Property (property="expires_in", type="integer", format="int32", example="315360000"),
 *              @OA\Property (property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbG...")
 *          ),
 *      ),
 * )
 */
Route::post('refresh', [AuthenticationApiController::class, 'proxyRefreshForApiClient'])
    ->name('api_authentication_client_api_app_refresh_proxy');
