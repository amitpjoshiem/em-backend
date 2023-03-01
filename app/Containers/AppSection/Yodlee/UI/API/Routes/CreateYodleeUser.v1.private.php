<?php

declare(strict_types=1);

/**
 * @OA\POST (
 *     path="/yodlee/{member_id}",
 *     tags={"Yodlee"},
 *     summary="Create",
 *     description="Create Yodlee User By Member ID",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Success Yodlee Account Created",
 *      ),
 *      @OA\Response(
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
 *                      property="yodlee",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected yodlee is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Yodlee\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::post('yodlee/{member_id}', [Controller::class, 'createYodleeUser'])
    ->name('api_yodlee_create_user')
    ->middleware(['auth:api', 'user_header']);
