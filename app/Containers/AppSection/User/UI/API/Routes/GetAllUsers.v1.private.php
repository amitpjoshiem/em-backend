<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/users",
 *     tags={"User"},
 *     summary="Get All Users",
 *     description="Get All Application Users (clients and admins). For all registered users 'Clients' only you can use `/clients`. And for all 'Admins' only you can use `/admins`.",
 *     @OA\Response(
 *         response=200,
 *         description="Returned All Users",
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
Route::get('users', [UserApiController::class, 'getAllUsers'])
    ->name('api_user_get_all_users')
    ->middleware(['auth:api', 'user_header']);
