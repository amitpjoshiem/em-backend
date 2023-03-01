<?php

declare(strict_types=1);

use App\Containers\AppSection\Media\UI\API\Controllers\Controller as MediaApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\GET (
 *     path="/media/rules/{collection}",
 *     tags={"Media"},
 *     summary="Media Collection Rules",
 *     description="Media Collection Rules",
 *     @OA\Parameter (
 *          description="Collection Name",
 *          name="collection",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="collection_name", summary="string value")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Media Rules",
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
Route::get('/media/rules/{collection}', [MediaApiController::class, 'getCollectionMediaRules'])
    ->name('api_media_get_collection_media_rules')
    ->middleware(['auth:api']);
