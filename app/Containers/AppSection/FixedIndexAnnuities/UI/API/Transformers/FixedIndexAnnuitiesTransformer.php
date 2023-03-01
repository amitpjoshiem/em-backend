<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\UI\API\Transformers;

use App\Containers\AppSection\FixedIndexAnnuities\Models\FixedIndexAnnuities;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelTransformerTrait;
use App\Containers\AppSection\Media\UI\API\Transformers\MediaTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

class FixedIndexAnnuitiesTransformer extends Transformer
{
    use IncludeMediaModelTransformerTrait;

    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'media',
        'certificate',
    ];

    /**
     * @var string[]
     */
    protected $availableIncludes = [

    ];

    public function transform(FixedIndexAnnuities $fixedindexannuities): array
    {
        $this->withMediaExpiration = true;

        return [
            'id'                  => $fixedindexannuities->getHashedKey(),
            'created_at'          => $fixedindexannuities->created_at->toDateString(),
            'name'                => $fixedindexannuities->name,
            'insurance_provider'  => $fixedindexannuities->insurance_provider,
            'advisor_signed'      => $fixedindexannuities->advisor_signed?->toDateString(),
            'client_signed'       => $fixedindexannuities->client_signed?->toDateString(),
            'is_advisor_signed'   => $fixedindexannuities->advisor_signed !== null,
            'is_client_signed'    => $fixedindexannuities->client_signed !== null,
            'tax_qualification'   => $fixedindexannuities->tax_qualification,
            'agent_rep_code'      => $fixedindexannuities->agent_rep_code,
            'license_number'      => $fixedindexannuities->license_number,
            'completed'           => $fixedindexannuities->advisor_signed !== null && $fixedindexannuities->client_signed !== null,
        ];
    }

    public function includeCertificate(FixedIndexAnnuities $fixedIndexAnnuities): NullResource|Item
    {
        if ($fixedIndexAnnuities->getCertificate() !== null) {
            return $this->item($fixedIndexAnnuities->getCertificate(), new MediaTransformer($this->withMediaExpiration, $this->unit, $this->value));
        }

        return $this->null();
    }
}
