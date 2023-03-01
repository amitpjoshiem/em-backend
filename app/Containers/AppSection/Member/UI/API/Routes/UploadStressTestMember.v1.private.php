<?php

declare(strict_types=1);

/**
 * @OA\Post (
 *     path="/members/stress_test/{member_id}",
 *     tags={"Stress Test"},
 *     summary="Upload Member Stress Test PDF",
 *     description="Upload Member Stress Test PDF",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\RequestBody(
 *          request="Stress Test",
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property(
 *                  property="uuids",
 *                  type="array",
 *                  @OA\Items(type="string", example="253f6ccf-367a-415e-b74f-98d4e96a1d70")
 *              )
 *          )
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Succes Upload"
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

Route::post('members/stress_test/{member_id}', [MemberApiController::class, 'uploadMemberStressTest'])
    ->name('api_member_upload_member_stress_test')
    ->middleware(['auth:api', 'user_header']);
