<?php

declare(strict_types=1);

/**
 * @apiGroup           Settings
 * @apiName            deleteSetting
 *
 * @api                {DELETE} /v1/settings/:id Delete Setting
 * @apiDescription     Deletes a setting entry
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated Admin
 *
 * @apiSuccessExample  {json}  Success-Response:
 * HTTP/1.1 204 No Content
 * {
 * }
 */

use App\Containers\AppSection\Settings\UI\API\Controllers\Controller as SettingsApiController;
use Illuminate\Support\Facades\Route;

Route::delete('settings/{id}', [SettingsApiController::class, 'deleteSetting'])
    ->name('api_settings_delete_setting')
    ->middleware(['auth:api']);
