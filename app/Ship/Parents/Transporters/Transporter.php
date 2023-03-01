<?php

namespace App\Ship\Parents\Transporters;

use App\Ship\Core\Abstracts\Transporters\Transporter as AbstractTransporter;
use App\Ship\Parents\Requests\Request;

abstract class Transporter extends AbstractTransporter
{
    public static function fromRequest(Request $request, array $payload = []): static
    {
        return new static(array_merge($request->toArray(), $payload));
    }

    public static function fromTransporter(AbstractTransporter $transporter, array $payload = []): static
    {
        return new static(array_merge($transporter->toArray(), $payload));
    }

    public static function fromArrayable(Request | array $data, array $payload = []): static
    {
        return new static($data, $payload);
    }
}
