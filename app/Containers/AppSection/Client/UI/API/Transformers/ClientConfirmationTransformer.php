<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Transformers;

use App\Containers\AppSection\Client\Data\Transporters\OutputClientConfirmationTransporter;
use App\Containers\AppSection\Client\Models\ClientConfirmation;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Primitive;

class ClientConfirmationTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'currently_have',
        'more_info_about',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(OutputClientConfirmationTransporter $data): array
    {
        return [
            'consultation' => $data->consultation,
        ];
    }

    public function includeCurrentlyHave(OutputClientConfirmationTransporter $data): Primitive
    {
        $currently_have = [];
        /**
         * @var ClientConfirmation $value
         */
        foreach ($data->currently_have as $value) {
            $currently_have[$value->item] = $value->value;
        }

        return $this->primitive($currently_have);
    }

    public function includeMoreInfoAbout(OutputClientConfirmationTransporter $data): Primitive
    {
        $more_info_about = [];
        /**
         * @var ClientConfirmation $value
         */
        foreach ($data->more_info_about as $value) {
            $more_info_about[$value->item] = $value->value;
        }

        return $this->primitive($more_info_about);
    }
}
