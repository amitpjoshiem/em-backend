<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/clients",
 *     tags={"User"},
 *     summary="Get All Client Users",
 *     description="Get All Users where role `User`.",
 *     @OA\Response(
 *         response=200,
 *         description="Returned All Client Users",
 *         @OA\JsonContent(
 *              @OA\Property(
 *                  property="users",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/User")
 *             )
 *         ),
 *     ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      ),
 *  )
 */
Route::get('clients', [UserApiController::class, 'getAllClients'])
    ->name('api_user_get_all_clients')
    ->middleware(['auth:api']);
