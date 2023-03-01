<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\Actions;

use App\Containers\AppSection\Otp\Services\GoogleOtpService;
use App\Ship\Parents\Actions\Action;
use stdClass;

class GetGoogleQrCodeUrlAction extends Action
{
    public function run(): stdClass
    {
        return (object)GoogleOtpService::generateQrCode();
    }
}
