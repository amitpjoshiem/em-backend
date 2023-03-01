<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Data\Transporters\GetCollectionMediaRulesTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class GetCollectionMediaRulesRequest extends Request
{
    protected ?string $transporter = GetCollectionMediaRulesTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    protected array $urlParameters = [
        'collection',
    ];

    public function rules(): array
    {
        return [
            'collection' => ['required', 'string', Rule::in(MediaCollectionEnum::toValues())],
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
