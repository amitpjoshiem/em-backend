<?php

declare(strict_types=1);

use App\Containers\AppSection\Init\UI\API\Controllers\Controller as InitApiController;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get(
 *     path="/init",
 *     tags={"Init"},
 *     summary="Init for start applications",
 *     operationId="InitCall",
 *     deprecated=false,
 *     @OA\Response(
 *          response=200,
 *          description="Return Initial List of value",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="collection-types",
 *                  type="array",
 *                  @OA\Items(type="string", example="default"),
 *                  @OA\Items(type="string", example="avatar")
 *              ),
 *          ),
 *      ),
 * )
 */
Route::get('init', [InitApiController::class, 'getAllInit'])
    ->name('api_init_get_all_init')
    ->middleware(['auth:api']);
