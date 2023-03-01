<?php

declare(strict_types=1);

use App\Containers\AppSection\Blueprint\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\POST (
 *     path="blueprint/share/{doc_id}",
 *     tags={"Blueprint Docs"},
 *     summary="Share Member Blueprint Report",
 *     description="Member Blueprint Report",
 *     @OA\Parameter(
 *          description="Document ID",
 *          name="doc_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="emails",
 *                  type="array",
 *                  @OA\Items(type="string", example="test@test.com")
 *              ),
 *          ),
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Succesful Start Send"
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
Route::post('blueprint/share/{doc_id}', [Controller::class, 'shareDoc'])
    ->name('api_blueprint_share_doc')
    ->middleware(['auth:api', 'user_header']);
