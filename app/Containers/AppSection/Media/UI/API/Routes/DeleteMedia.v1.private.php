<?php

declare(strict_types=1);

use App\Containers\AppSection\Media\UI\API\Controllers\Controller as MediaApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Delete (
 *     path="/media/{id}",
 *     tags={"Media"},
 *     summary="Media",
 *     description="Media",
 *     @OA\Parameter (
 *          description="Media ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="string value")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="",
 *          @OA\JsonContent(ref="#/components/schemas/Media")
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
 *                      property="media",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected media is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */
Route::delete('media/{id}', [MediaApiController::class, 'deleteMedia'])
    ->name('api_media_delete_media')
    ->middleware(['auth:api', 'client_readonly']);
