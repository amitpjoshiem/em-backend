<?php

declare(strict_types=1);

/**
 * @OA\GET (
 *     path="/assets_consolidations/{member_id}/export/excel",
 *     tags={"AssetsConsolidations"},
 *     summary="Get All AssetsConsolidations",
 *     description="Get All AssetsConsolidations For Member",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
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

Route::get('/assets_consolidations/{member_id}/export/excel', [Controller::class, 'getAllAssetsConsolidationsExcelExports'])
    ->name('api_assetsconsolidations_get_all_assets_consolidations_excel_exports')
    ->middleware(['auth:api', 'user_header']);
