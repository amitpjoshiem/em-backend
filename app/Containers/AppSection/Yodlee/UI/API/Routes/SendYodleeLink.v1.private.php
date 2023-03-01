<?php

declare(strict_types=1);

/**
 * @OA\Get (
 *     path="/yodlee/{member_id}/link",
 *     tags={"Yodlee"},
 *     summary="Fastlink",
 *     description="Send Fastlink to member",
 *     @OA\Parameter(
 *          description="Member ID",
 *          name="id",
 *          in="path",
 *          required=true,
 *          @OA\Examples(example="string", value="bpy390dg3jova6gm", summary="")
 *     ),
 *      @OA\Response(
 *          response=204,
 *          description="Success Sended Link",
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

use App\Containers\AppSection\Yodlee\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('yodlee/{member_id}/link', [Controller::class, 'sendYodleeLink'])
    ->name('api_yodlee_send_link')
    ->middleware(['auth:api', 'user_header']);
