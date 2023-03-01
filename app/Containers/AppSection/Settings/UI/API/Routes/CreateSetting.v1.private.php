<?php

declare(strict_types=1);

/**
 * @apiGroup           Settings
 * @apiName            createSetting
 *
 * @api                {POST} /v1/settings Create Setting
 * @apiDescription     Create a new setting for the application
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Admin
 *
 * @apiParam           {String}  key max:190
 * @apiParam           {String}  value max:190
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data": {
 * "object": "Setting",
 * "id": "aadfa72342sa",
 * "key": "hello",
 * "value": "world"
 * },
 * "meta": {
 * "include": [],
 * "custom": []
 * }
 * }
 */

use App\Containers\AppSection\Settings\UI\API\Controllers\Controller as SettingsApiController;
use Illuminate\Support\Facades\Route;

Route::post('settings', [SettingsApiController::class, 'createSetting'])
    ->name('api_settings_create_setting')
    ->middleware(['auth:api']);
