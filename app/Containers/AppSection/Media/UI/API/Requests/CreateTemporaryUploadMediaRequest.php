<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Data\Transporters\CreateTemporaryUploadMediaTransporter;
use App\Containers\AppSection\Media\UI\API\Rules\MediaExtensionRule;
use App\Containers\AppSection\Media\UI\API\Rules\MediaSizeRule;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class CreateTemporaryUploadMediaRequest extends Request
{
    protected ?string $transporter = CreateTemporaryUploadMediaTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function rules(): array
    {
        return [
            'file'       => [
                'required_without:files',
                new MediaExtensionRule($this->get('collection')),
                new MediaSizeRule($this->get('collection')),
            ],
            'files'      => ['required_without:file', 'array'],
            'files.*'    => [
                'filled',
                'required',
                new MediaExtensionRule($this->get('collection')),
                new MediaSizeRule($this->get('collection')),
            ],
            'collection' => ['filled', 'string', Rule::in(MediaCollectionEnum::toValues())],
        ];
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
