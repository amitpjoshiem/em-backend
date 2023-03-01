<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/stats/users",
 *     tags={"User"},
 *     summary="Get All Users Stats",
 *     description="Get All Users Stats",
 *     @OA\Response(
 *         response=200,
 *         description="Returned Users Stats",
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
Route::get('/stats/users', [UserApiController::class, 'getUsersStats'])
    ->name('api_user_get_users_stats')
    ->middleware(['auth:api', 'user_header']);
