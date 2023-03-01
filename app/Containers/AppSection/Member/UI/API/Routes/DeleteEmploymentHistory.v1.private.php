<?php

declare(strict_types=1);

/**
 * @OA\DELETE (
 *     path="/employment_history/{id}",
 *     tags={"Member"},
 *     summary="Delete Employment History",
 *     description="Delete Employment History",
 *     @OA\Parameter(
 *          description="Employment History ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Success Deleted Employment History"
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

use App\Containers\AppSection\Member\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::delete('employment_history/{id}', [Controller::class, 'deleteEmploymentHistory'])
    ->name('api_member_delete_employment_history')
    ->middleware(['auth:api', 'user_header']);
