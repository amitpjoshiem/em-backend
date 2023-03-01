<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Requests;

use App\Containers\AppSection\Client\Data\Transporters\UploadClientDocsTransporter;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class UploadClientDocsRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UploadClientDocsTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'collection',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'collection'    => ['required', 'string', Rule::in(MediaCollectionEnum::clientDocsType())],
            'name'          => 'string|required',
            'description'   => 'string|nullable|max:60',
            'type'          => sprintf('string|required_if:collection,%s|nullable|max:60', MediaCollectionEnum::INVESTMENT_AND_RETIREMENT_ACCOUNTS),
            'is_spouse'     => 'bool|required',
        ];

        return $merger->setAllowedCollectionTypes(MediaCollectionEnum::clientDocsType())->run($rules);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
