<?php

declare(strict_types=1);

use App\Containers\AppSection\Blueprint\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\GET (
 *     path="blueprint/docs/{member_id}",
 *     tags={"Blueprint Docs"},
 *     summary="Get Member Blueprint Report",
 *     description="GEt Member Blueprint Report Link",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Return link of generated file",
 *          @OA\JsonContent(
 *              @OA\Property (property="link", type="string")
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
 *              @OA\Property (property="message", type="string", example="The given data was invalid.")
 *          ),
 *      ),
 *  )
 */
Route::get('blueprint/docs/{member_id}', [Controller::class, 'getAllDocs'])
    ->name('api_blueprint_get_all_docs')
    ->middleware(['auth:api', 'user_header']);
