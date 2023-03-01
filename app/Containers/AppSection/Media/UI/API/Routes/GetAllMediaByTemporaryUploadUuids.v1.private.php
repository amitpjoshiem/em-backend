<?php

declare(strict_types=1);

use App\Containers\AppSection\Media\UI\API\Controllers\Controller as MediaApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\GET (
 *     path="/media",
 *     tags={"Media"},
 *     summary="Media",
 *     description="Media",
 *     @OA\RequestBody(
 *          required=true,
 *          @OA\JsonContent(
 *              required={"uuids"},
 *              @OA\Property (property="uuids", type="array", @OA\Items(type="string", example="d01dbec5-c86a-453c-8658-9386df12c766")),
 *          ),
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
Route::get('media', [MediaApiController::class, 'getAllMediaByTemporaryUploadUuids'])
    ->name('api_media_get_all_media_by_temporary_upload_uuids')
    ->middleware(['auth:api']);
