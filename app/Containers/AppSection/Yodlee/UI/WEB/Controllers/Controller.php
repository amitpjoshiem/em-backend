<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\UI\WEB\Controllers;

use App\Containers\AppSection\Yodlee\Actions\GetYodleeLinkDataAction;
use App\Containers\AppSection\Yodlee\UI\WEB\Requests\YodleeLinkRequest;
use App\Ship\Parents\Controllers\WebController;
use Illuminate\View\View;

class Controller extends WebController
{
    public function yodleeLink(YodleeLinkRequest $request): View
    {
        $yodleeData = app(GetYodleeLinkDataAction::class)->run($request->toTransporter());

        return view('appSection@yodlee::yodlee-link', $yodleeData);
    }
}
