<?php

declare(strict_types=1);

/**
 * @OA\Put (
 *     path="/assets_consolidations/table/{table_id}",
 *     tags={"AssetsConsolidations"},
 *     summary="Create AssetsConsolidation Table",
 *     description="AssetsConsolidations Create Table",
 *     @OA\Parameter(
 *          description="Table ID",
 *          name="table_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\RequestBody(
 *          required=false,
 *          @OA\JsonContent(ref="#/components/schemas/AssetsConsolidationsTable")
 *     ),
 *     @OA\Response(
 *          response=200,
 *          description="Returned AssetsConsolidations",
 *          @OA\JsonContent(
 *              @OA\Property (
 *                  property="data",
 *                  type="array",
 *                  @OA\Items(ref="#/components/schemas/AssetsConsolidationsOutput")
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
 *                      property="assetsconsolidations",
 *                      type="array",
 *                      @OA\Items(type="string", example="The selected assetsconsolidations is invalid.")
 *                  )
 *              ),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\AssetsConsolidations\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::put('assets_consolidations/table/{table_id}', [Controller::class, 'updateAssetsConsolidationsTable'])
    ->name('api_assetsconsolidations_update_assets_consolidations_table')
    ->middleware(['auth:api', 'user_header']);
