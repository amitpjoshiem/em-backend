<?php

declare(strict_types=1);

use App\Containers\AppSection\Authentication\UI\API\Controllers\Controller as AuthenticationApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *      path="/login",
 *      tags={"OAuth2"},
 *      summary="User login",
 *      description="Login Users using their email and password, without client_id and client_secret.",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email","password"},
 *              @OA\Property (property="email", type="string", example="test@test.com"),
 *              @OA\Property (property="password", type="string", example="password")
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
Route::post('login', [AuthenticationApiController::class, 'proxyLoginForApiClient'])
    ->name('api_authentication_client_api_app_login_proxy');
