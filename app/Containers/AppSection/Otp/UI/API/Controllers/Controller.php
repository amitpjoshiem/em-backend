<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Controllers;

use App\Containers\AppSection\Otp\Actions\ChangeOtpServiceAction;
use App\Containers\AppSection\Otp\Actions\GetGoogleQrCodeUrlAction;
use App\Containers\AppSection\Otp\Actions\ReSendOtpAction;
use App\Containers\AppSection\Otp\Actions\VerifyOtpAction;
use App\Containers\AppSection\Otp\UI\API\Requests\ChangeOtpRequest;
use App\Containers\AppSection\Otp\UI\API\Requests\VerifyOtpRequest;
use App\Containers\AppSection\Otp\UI\API\Transformers\QrTransformer;
use App\Ship\Core\Exceptions\InvalidTransformerException;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

class Controller extends ApiController
{
    public function verifyOtp(VerifyOtpRequest $request): JsonResponse
    {
        $cookie = app(VerifyOtpAction::class)->run($request->toTransporter());

        return $this->noContent()->withCookie($cookie);
    }

    public function changeOtp(ChangeOtpRequest $request): JsonResponse
    {
        $cookie = app(ChangeOtpServiceAction::class)->run($request->toTransporter());

        $response = $this->noContent();

        if ($cookie !== null) {
            $response->withCookie($cookie);
        }

        return $response;
    }

    /**
     * @throws InvalidTransformerException
     */
    public function googleQr(): array
    {
        $qr = app(GetGoogleQrCodeUrlAction::class)->run();

        return $this->transform($qr, QrTransformer::class, resourceKey: 'data');
    }

    public function reSendOtp(): JsonResponse
    {
        app(ReSendOtpAction::class)->run();

        return $this->noContent();
    }
}
