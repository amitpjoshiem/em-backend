<?php

declare(strict_types=1);

use App\Containers\AppSection\User\UI\API\Controllers\Controller as UserApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/users/{id}",
 *     tags={"User"},
 *     summary="Find User",
 *     description="Find a user by its ID",
 *     @OA\Parameter(
 *          description="User ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="string value")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Returned User",
 *         @OA\JsonContent(
 *             @OA\Schema(ref="#/components/schemas/User")
 *         ),
 *     ),
 *     @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
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
Route::get('users/{id}', [UserApiController::class, 'findUserById'])
    ->name('api_user_find_user')
    ->middleware(['auth:api']);
