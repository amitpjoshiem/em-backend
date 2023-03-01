<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/members/stress_test/{member_id}",
 *     tags={"Stress Test"},
 *     summary="Get All Member Stress Tests PDF",
 *     description="Get All Member Stress Tests PDF",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned PDF Files",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(
 *                      @OA\Property(property="name", type="string", example="simple.pdf"),
 *                      @OA\Property(property="url", type="string", example="https://path-to-file.com/some-data"),
 *                      @OA\Property(property="link_expire", type="string", example="1970-01-01 12:00:00"),
 *                      @OA\Property(property="created_at", type="string", example="1970-01-01 12:00:00"),
 *                  )
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

Route::get('members/stress_test/{member_id}', [MemberApiController::class, 'getAllMemberStressTests'])
    ->name('api_member_get_all_member_stress_tests')
    ->middleware(['auth:api', 'user_header']);
