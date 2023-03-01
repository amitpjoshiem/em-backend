<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\UI\WEB\Controllers;

use App\Containers\AppSection\Authentication\Actions\WebLoginAction;
use App\Containers\AppSection\Authentication\Actions\WebLogoutAction;
use App\Containers\AppSection\Authentication\Actions\WebSessionInvalidateAction;
use App\Containers\AppSection\Authentication\Actions\WebSessionRegenerateAction;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LoginRequest;
use App\Containers\AppSection\Authentication\UI\WEB\Requests\LogoutRequest;
use App\Ship\Parents\Controllers\WebController;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class Controller extends WebController
{
    public function showLoginPage(): View
    {
        return view('appSection@authentication::login');
    }

    public function logout(LogoutRequest $request): RedirectResponse
    {
        app(WebLogoutAction::class)->run();

        app(WebSessionInvalidateAction::class)->run($request->toTransporter());

        return redirect('/');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        try {
            app(WebLoginAction::class)->run($request->toTransporter());

            app(WebSessionRegenerateAction::class)->run($request);
        } catch (Exception $exception) {
            return redirect()
                ->route(config('appSection-authentication.login-page-url'))
                ->with('status', $exception->getMessage());
        }

        return redirect()->intended();
    }
}
