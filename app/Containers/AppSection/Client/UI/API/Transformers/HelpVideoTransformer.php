<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Data\Transporters\OutputClientHelpTransporter;
use App\Ship\Parents\Transformers\Transformer;

class HelpVideoTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [

    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(OutputClientHelpTransporter $help): array
    {
        return [
            'url'  => $help->media?->getTemporaryUrl(now()->addMinutes(30)),
            'text' => $help->text,
            'type' => $help->type,
        ];
    }
}
