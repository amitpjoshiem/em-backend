<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/admins",
 *     tags={"User"},
 *     summary="Get All Admin Users",
 *     description="Get All Users where role `Admin`.",
 *     @OA\Response(
 *         response=200,
 *         description="Returned All Admin Users",
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
Route::get('admins', [UserApiController::class, 'getAllAdmins'])
    ->name('api_user_get_all_admins')
    ->middleware(['auth:api']);
