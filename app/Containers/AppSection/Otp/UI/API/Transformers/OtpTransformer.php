<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Transformers;

use App\Containers\AppSection\Otp\Models\Otp;
use App\Ship\Parents\Transformers\Transformer;

class OtpTransformer extends Transformer
{
    public function transform(Otp $otp): array
    {
        return [
            'object'              => $otp->getResourceKey(),
            'id'                  => $otp->getHashedKey(),
            'created_at'          => $otp->created_at,
            'updated_at'          => $otp->updated_at,
        ];
    }
}
