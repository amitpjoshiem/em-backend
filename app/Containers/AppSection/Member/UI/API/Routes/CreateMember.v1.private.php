<?php

declare(strict_types=1);

/**
 * @OA\POST (
 *     path="/members",
 *     tags={"Member"},
 *     summary="Create Member",
 *     description="Member",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(ref="#/components/schemas/Member")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Member",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/Member")
 *              ),
 *          ),
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
 *                      property="member",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected member is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Member\UI\API\Controllers\Controller as MemberApiController;
use Illuminate\Support\Facades\Route;

Route::post('members', [MemberApiController::class, 'createMember'])
    ->name('api_member_create_member')
    ->middleware(['auth:api', 'user_header']);
