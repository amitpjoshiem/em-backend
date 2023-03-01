<?php

declare(strict_types=1);

/**
 * @OA\Delete  (
 *     path="/members/contacts/{id}",
 *     tags={"Member Contacts"},
 *     summary="Delete Member Contacts",
 *     description="Delete Member Contacts",
 *     @OA\Parameter(
 *          description="Contact ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Delete Succesfully",
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

Route::delete('members/contacts/{id}', [MemberApiController::class, 'deleteMemberContact'])
    ->name('api_member_delete_member_contact')
    ->middleware(['auth:api', 'user_header']);
