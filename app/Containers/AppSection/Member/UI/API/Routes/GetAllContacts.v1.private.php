<?php

declare(strict_types=1);

/**
 * @OA\GET(
 *     path="/members/contacts/{member_id}",
 *     tags={"Member Contacts"},
 *     summary="Get All Member Contacts",
 *     description="Get All Member Contacts",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Member Contact",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/MemberContact")
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

Route::get('members/contacts/{member_id}', [MemberApiController::class, 'getAllMemberContacts'])
    ->name('api_member_get_all_member_contacts')
    ->middleware(['auth:api', 'user_header']);
