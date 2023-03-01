<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\UI\API\Transformers;

use App\Containers\AppSection\FixedIndexAnnuities\Models\InvestmentPackage;
use App\Containers\AppSection\Media\Traits\IncludeMediaModelTransformerTrait;
use App\Containers\AppSection\Media\UI\API\Transformers\MediaTransformer;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\NullResource;

class InvestmentPackageTransformer extends Transformer
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

    public function transform(InvestmentPackage $investmentPackage): array
    {
        $this->withMediaExpiration = true;

        return [
            'id'                  => $investmentPackage->getHashedKey(),
            'created_at'          => $investmentPackage->created_at->toDateString(),
            'name'                => $investmentPackage->name,
            'advisor_signed'      => $investmentPackage->advisor_signed?->toDateString(),
            'client_signed'       => $investmentPackage->client_signed?->toDateString(),
            'is_advisor_signed'   => $investmentPackage->advisor_signed !== null,
            'is_client_signed'    => $investmentPackage->client_signed !== null,
            'completed'           => $investmentPackage->advisor_signed !== null && $investmentPackage->client_signed !== null,
        ];
    }

    public function includeCertificate(InvestmentPackage $investmentPackage): NullResource|Item
    {
        if ($investmentPackage->getCertificate() !== null) {
            return $this->item($investmentPackage->getCertificate(), new MediaTransformer($this->withMediaExpiration, $this->unit, $this->value));
        }

        return $this->null();
    }
}
