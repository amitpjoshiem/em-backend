<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\Actions;

use App\Containers\AppSection\Authentication\Data\Transporters\LogoutTransporter;
use App\Ship\Parents\Actions\Action;

class WebSessionInvalidateAction extends Action
{
    public function run(LogoutTransporter $transporter): void
    {
        $transporter->request->session()->invalidate();

        $transporter->request->session()->regenerateToken();
    }
}
