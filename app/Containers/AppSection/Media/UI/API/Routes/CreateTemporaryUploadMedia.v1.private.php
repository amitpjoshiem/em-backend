<?php

declare(strict_types=1);

use App\Containers\AppSection\Media\UI\API\Controllers\Controller as MediaApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/media",
 *     tags={"Media"},
 *     summary="Media",
 *     description="Upload media request body",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  @OA\Property(property="file", description="files to upload", type="string", format="binary"),
 *                  @OA\Property(property="files", description="files to upload", type="array", @OA\Items(type="string", format="binary")),
 *                  @OA\Property(property="collection", description="type of file", type="string", example="avatar"),
 *                  required={"collection"}
 *              )
 *          )
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Media",
 *          @OA\JsonContent(
 *              @OA\Property (property="media", type="string", example="Media"),
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exception occurred when trying to authenticate the User."),
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
Route::post('media', [MediaApiController::class, 'createTemporaryUploadMedia'])
    ->name('api_media_create_temporary_upload_media')
    ->middleware(['auth:api', 'client_readonly']);
