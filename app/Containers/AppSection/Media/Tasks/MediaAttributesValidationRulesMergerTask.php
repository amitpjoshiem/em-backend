<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\Tasks;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Validation\Rule;

class MediaAttributesValidationRulesMergerTask extends Task
{
    private ?array $allowedCollectionTypes = null;

    public function run(array $rules = [], bool $isUuidsRequired = false, bool $isCollectionRequired = false): array
    {
        $mediaValidationRules = [
            'uuids'      => [$isUuidsRequired ? 'required' : 'filled', 'array'],
            'uuids.*'    => 'filled|exists:temporary_uploads,uuid',
            'collection' => [$isCollectionRequired ? 'required' : 'filled', 'string', Rule::in($this->getAllowedCollectionTypes())],
        ];

        return array_merge($rules, $mediaValidationRules);
    }

    public function getAllowedCollectionTypes(): array
    {
        return $this->allowedCollectionTypes ?? [MediaCollectionEnum::DEFAULT];
    }

    public function setAllowedCollectionTypes(array $types): self
    {
        $this->allowedCollectionTypes = $types;

        return $this;
    }
}
