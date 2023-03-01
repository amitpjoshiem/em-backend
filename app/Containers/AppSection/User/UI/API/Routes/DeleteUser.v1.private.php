<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post(
 *      path="/users",
 *      tags={"User"},
 *      summary="Delete User",
 *      description="Delete users of any type (Admin, User)",
 *      @OA\Parameter(
 *           description="User ID",
 *           name="id",
 *           in="path",
 *           required=true,
 *           @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="string value")
 *      ),
 *      @OA\Response(
 *           response=204,
 *           description="User Deleted Successfully.",
 *      ),
 *      @OA\Response(
 *          response=422,
 *          description="Unprocessable Entity",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="The given data was invalid."),
 *              @OA\Property (
 *                  property="errors",
 *                  type="object",
 *                  @OA\Property(
 *                      property="account",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected account is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 * )
 */
Route::delete('users/{id}', [UserApiController::class, 'deleteUser'])
    ->name('api_user_delete_user')
    ->middleware('auth:api');
