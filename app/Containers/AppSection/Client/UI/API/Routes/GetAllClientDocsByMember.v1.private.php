<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/clients/docs/get/{member_id}/{collection}",
 *     tags={"Client"},
 *     summary="Get All CLient Docs By Member",
 *     description="Get All CLient Docs By Member",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="member_id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\Parameter(
 *          description="Collection",
 *          name="collection",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="test_collection", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Confirmed AssetsConsolidations",
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

use App\Containers\AppSection\Client\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('clients/docs/get/{member_id}/{collection}', [Controller::class, 'getAllClientDocsByMember'])
    ->name('api_client_get_client_docs_by_member')
    ->middleware(['auth:api', 'user_header', 'terms_and_conditions']);
