<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Init\UI\API\Transformers;

use App\Containers\AppSection\Init\Data\Transporters\OutputInitTransporter;
use App\Ship\Parents\Transformers\Transformer;

class InitTransformer extends Transformer
{
    public function transform(OutputInitTransporter $init): array
    {
        $data = [
            'roles'      => $init->roles->pluck('name')->toArray(),
            'user_id'    => $init->user_id,
            'company_id' => $init->company_id,
            'advisor_id' => $init->advisor_id,
        ];

        if ($init->terms_and_conditions !== null) {
            $data['terms_and_conditions'] = $init->terms_and_conditions;
        }

        if ($init->member_type !== null) {
            $data['member_type'] = $init->member_type;
        }

        if ($init->member_id !== null) {
            $data['member_id'] = $init->member_id;
        }

        if ($init->readonly !== null) {
            $data['readonly'] = $init->readonly;
        }

        return $data;
    }
}
