<?php

declare(strict_types=1);

/**
 * @OA\GET (
 *     path="/notification/channel",
 *     tags={"Notifications"},
 *     summary="Generate Test Notification",
 *     description="Generate test notification for websocket ['notification' => 'This is Test Notification']",
 *      @OA\Response(
 *          response=200,
 *          description="Succesfuly created Notification",
 *          @OA\JsonContent(
 *              @OA\Property(property="channel", type="string", example="lqm9nej3b8rzb6ka")
 *          ),
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthorized",
 *          @OA\JsonContent(
 *              @OA\Property (property="message", type="string", example="An Exceptions occurred when trying to authenticate the User."),
 *          ),
 *      ),
 *  )
 */

use App\Containers\AppSection\Notification\UI\API\Controllers\Controller;
use Illuminate\Support\Facades\Route;

Route::get('/notification/channel', [Controller::class, 'getNotificationChannel'])
    ->middleware('auth:api');
