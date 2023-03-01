<?php

declare(strict_types=1);

/**
 * @OA\Patch (
 *     path="/members/{id}",
 *     tags={"Member"},
 *     summary="Update Member",
 *     description="Update Member Info By ID",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\RequestBody(
 *          request="Member",
 *          required=false,
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

Route::patch('members/{id}', [MemberApiController::class, 'updateMember'])
    ->name('api_member_update_member')
    ->middleware(['auth:api', 'user_header', 'client_readonly']);
