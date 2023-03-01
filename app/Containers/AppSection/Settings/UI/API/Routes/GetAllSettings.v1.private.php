<?php

declare(strict_types=1);

/**
 * @apiGroup           Settings
 * @apiName            getAllSettings
 *
 * @api                {GET} /v1/settings Get All Settings
 * @apiDescription     Get All settings for the application
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Admin
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 200 OK
 * {
 * "data": [
 * {
 * "object": "Setting",
 * "id": "damq35egme74k0xv",
 * "key": "foo",
 * "value": "bar"
 * },
 * {
 * "object": "Setting",
 * "id": "damq35egme74k0xv",
 * "key": "test",
 * "value": "456"
 * },
 * {
 * "object": "Setting",
 * "id": "damq35egme74k0xv",
 * "key": "logout",
 * "value": "false"
 * }
 * ],
 * "meta": {
 *
 * }
 * }
 */

use App\Containers\AppSection\Settings\UI\API\Controllers\Controller as SettingsApiController;
use Illuminate\Support\Facades\Route;

Route::get('settings', [SettingsApiController::class, 'getAllSettings'])
    ->name('api_settings_get_all_settings')
    ->middleware(['auth:api']);
