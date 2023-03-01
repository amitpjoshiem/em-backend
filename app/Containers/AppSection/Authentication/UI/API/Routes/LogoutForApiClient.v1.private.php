<?php

declare(strict_types=1);

use App\Containers\AppSection\Authentication\UI\API\Controllers\Controller as AuthenticationApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Delete (
 *     path="/logout",
 *     tags={"OAuth2"},
 *     summary="User logout",
 *     description="User Logout. (Revoking Access Token)",
 *     @OA\Response (
 *          description="Return success of logout token.",
 *          response=202,
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="Return success of logout token."),
 *          ),
 *     ),
 * )
 */
Route::delete('logout', [AuthenticationApiController::class, 'logoutForApiClient'])
    ->name('api_authentication_logout')
    ->middleware(['auth:api']);
