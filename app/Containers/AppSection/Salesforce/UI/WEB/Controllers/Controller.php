<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\WEB\Controllers;

use App\Containers\AppSection\Salesforce\Actions\AuthenticateUserInSalesforceAction;
use App\Containers\AppSection\Salesforce\Exceptions\SalesforceUserAlreadyExistException;
use App\Containers\AppSection\Salesforce\UI\WEB\Requests\AuthCallbackRequest;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\Http\RedirectResponse;

class Controller extends WebController
{
    public function authCallback(AuthCallbackRequest $request): RedirectResponse
    {
        try {
            app(AuthenticateUserInSalesforceAction::class)->run($request->toTransporter());
        } catch (SalesforceUserAlreadyExistException $salesforceUserAlreadyExistException) {
            $url    = config('app.frontend_url') . config('app.front_end_error');
            $params = sprintf('?message=%s&type=%s', $salesforceUserAlreadyExistException->getMessage(), 'salesforce');

            return redirect()->away($url . $params);
        }

        return redirect()->away(config('app.frontend_url') . config('appSection-salesforce.salesforce_front_path'));
    }
}
