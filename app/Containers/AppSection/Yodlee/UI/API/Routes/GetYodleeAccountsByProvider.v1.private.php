<?php

declare(strict_types=1);

use App\Containers\AppSection\Yodlee\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Get (
 *     path="/yodlee/{member_id}/accounts/{provider_id}",
 *     tags={"Yodlee"},
 *     summary="Accounts",
 *     description="Get Member Yodlee Accounts By ProviderID",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *     @OA\Parameter(
 *          description="Provider ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=200,
 *          description="Returned Accounts",
 *          @OA\JsonContent(
 *              @OA\Property (property="data", type="array",
 *                  @OA\Items(
 *                      @OA\Property (property="container", type="string", example="loan"),
 *                      @OA\Property (property="name", type="string", example="Lendin Club personal loan - x7608"),
 *                      @OA\Property (property="status", type="string", example="ACTIVE"),
 *                      @OA\Property (property="balance", type="string", example="23156.71 USD"),
 *                      @OA\Property (property="type", type="string", example="PERSONAL_LOAN"),
 *                  ),
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
 *              ),
 *          ),
 *      ),
 *  )
 */
Route::get('yodlee/{member_id}/accounts/{provider_id}', [Controller::class, 'getYodleeAccountsByProvider'])
    ->name('api_yodlee_accounts')
    ->middleware(['auth:api', 'user_header']);
