<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Transformers;

use App\Ship\Parents\Transformers\Transformer;

class QrTransformer extends Transformer
{
    public function transform(object $qr): array
    {
        return [
            'code'   => $qr->code,
            'data'   => $qr->data,
        ];
    }
}
