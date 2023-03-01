<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/salesforce/opportunity/create/{member_id}",
 *     tags={"Salesforce"},
 *     summary="Create Salesfroce Opportunity",
 *     description="Create Salesfroce Opportunity By Member",
 *      @OA\Response(
 *          response=204,
 *          description="Succesfully Created",
 *          @OA\JsonContent(
 *              @OA\Property (property="status", type="bool", example=false),
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
 *          ),
 *      ),
 *  )
 */
Route::post('/salesforce/opportunity/create/{member_id}', [Controller::class, 'createOpportunity'])
    ->name('api_salesforce_create_opportunity')
    ->middleware(['auth:api', 'user_header']);
