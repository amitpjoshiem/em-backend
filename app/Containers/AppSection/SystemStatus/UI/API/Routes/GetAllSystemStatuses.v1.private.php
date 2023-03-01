<?php

declare(strict_types=1);

use App\Containers\AppSection\SystemStatus\UI\API\Controllers\Controller as StatusApiController;
use Illuminate\Support\Facades\Route;

/**
 * @api                {GET} /v1/ping System Health Check
 * @apiVersion         1.0.0
 * @apiName            getAllSystemStatuses
 * @apiGroup           SystemStatus
 * @apiPermission      none
 *
 * @apiDescription     System Health Check
 *
 * @apiHeader          {String} ContentType=application/json;charset=UTF-8 ContentType
 * @apiHeader          {String} Accept=application/json;charset=UTF-8 Accept
 * @apiHeaderExample   {json} headerExample:
 *    {
 *        "Content-Type": "application/json;charset=UTF-8",
 *        "Accept": "application/json;charset=UTF-8",
 *    }
 *
 * @apiSuccessExample  {json} Success-Response:
 *    HTTP/1.1 200 OK
 *    {
 *        "data": [
 *            {
 *                "object": "SystemStatus",
 *                "id": ""
 *            }
 *        ],
 *        "meta": {
 *            "include": [],
 *            "custom": []
 *        }
 *    }
 */
Route::get('/ping', [StatusApiController::class, 'getAllSystemStatuses'])
    ->name('api_ping_get_all_system_statuses');
