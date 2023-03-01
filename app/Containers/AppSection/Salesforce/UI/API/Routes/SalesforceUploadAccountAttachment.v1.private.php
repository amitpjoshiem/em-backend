<?php

declare(strict_types=1);

use App\Containers\AppSection\Salesforce\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/**
 * @OA\Post (
 *     path="/salesforce/account/upload/{member_id}",
 *     tags={"Salesforce"},
 *     summary="Upload Salesforce Opportunity Attachment",
 *     description="Upload Salesforce Opportunity Attachment",
 *      @OA\Response(
 *          response=200,
 *          description="Returned Status",
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
Route::post('/salesforce/account/upload/{member_id}', [Controller::class, 'uploadAccountAttachment'])
    ->name('api_salesforce_upload_account_attachment')
    ->middleware(['auth:api', 'user_header']);
