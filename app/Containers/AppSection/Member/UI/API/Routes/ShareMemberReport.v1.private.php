<?php

declare(strict_types=1);

/**
 * @OA\POST (
 *     path="/members/report",
 *     tags={"Member"},
 *     summary="Share Member Report",
 *     description="Member Report",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="emails",
 *                  type="array",
 *                  @OA\Items(type="string", example="test@test.com")
 *              ),
 *              @OA\Property (
 *                  property="uuids",
 *                  type="array",
 *                  @OA\Items(type="string", example="76e6c74b-fa20-4e0d-89c8-1a1714f676ce")
 *              )
 *          ),
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Succesfule Start Send"
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
 *              @OA\Property (property="message", type="string", example="The given data was invalid.")
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Member\UI\API\Controllers\Controller as MemberApiController;
use Illuminate\Support\Facades\Route;

Route::post('members/report', [MemberApiController::class, 'shareMemberReport'])
    ->name('api_member_share_report')
    ->middleware(['auth:api', 'user_header']);
