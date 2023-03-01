<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/stats/members",
 *     tags={"Member"},
 *     summary="Member Statistics",
 *     description="Member Statistics",
 *      @OA\Response(
 *          response=204,
 *          description="Member Statistics"
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

Route::get('stats/members', [MemberApiController::class, 'memberStatistics'])
    ->name('api_member_member_stats')
    ->middleware(['auth:api', 'user_header']);
