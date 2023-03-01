<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Data\Transporters\GetAllMediaByTemporaryUploadUuidsTransporter;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;

class GetAllMediaByTemporaryUploadUuidsRequest extends Request
{
    protected ?string $transporter = GetAllMediaByTemporaryUploadUuidsTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        return $merger
            ->setAllowedCollectionTypes([MediaCollectionEnum::DEFAULT])
            ->run(isUuidsRequired: true);
    }

    /**
     * Check if the authenticated user actually has the authority to change a given resource.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
