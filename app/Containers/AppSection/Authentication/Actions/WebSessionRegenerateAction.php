<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\UI\WEB\Requests\LoginRequest;
use App\Ship\Parents\Actions\Action;

class WebSessionRegenerateAction extends Action
{
    public function run(LoginRequest $request): void
    {
        $request->session()->regenerate();
    }
}
