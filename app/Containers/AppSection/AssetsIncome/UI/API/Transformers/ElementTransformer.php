<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\UI\API\Transformers;

use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\BasicElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\DropdownElement;
use App\Containers\AppSection\AssetsIncome\Data\Schemas\Elements\InputElement;
use App\Ship\Parents\Transformers\Transformer;

class ElementTransformer extends Transformer
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

    public function transform(BasicElement $element): array
    {
        $params = [
            'type'          => $element->getType(),
            'name'          => $element->name,
            'label'         => $element->label,
            'disabled'      => $element->disabled,
            'calculated'    => $element->calculated,
            'model'         => $element->getModel(),
        ];

        if ($element instanceof DropdownElement) {
            $params['options'] = $element->getOptions();
        }

        if ($element instanceof InputElement) {
            $params['placeholder'] = $element->getPlaceholder();
        }

        return $params;
    }
}
