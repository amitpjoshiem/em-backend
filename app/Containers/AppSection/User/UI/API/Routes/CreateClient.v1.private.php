<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *     path="/clients/create",
 *     tags={"Clients"},
 *     summary="Create Client User",
 *     description="Create Client User",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"email"},
 *              @OA\Property (property="email", type="string", maxLength=255, format="email", example="test@test.com"),
 *          ),
 *     ),
 *     @OA\Response(
 *         response=204,
 *         description="Succesfully Create Client User",
 *     ),
 * )
 */
Route::post('/clients/create', [UserApiController::class, 'createClient'])
    ->name('api_user_create_client')
    ->middleware(['auth:api']);
