<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\API\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\UpdateClientHelpTransporter;
use App\Containers\AppSection\Client\Data\Enums\ClientHelpPagesEnum;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateClientHelpRequest extends Request
{
    protected ?string $transporter = UpdateClientHelpTransporter::class;

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
        //        'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'type',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'type' => ['required', Rule::in(ClientHelpPagesEnum::values())],
            'text' => 'nullable|string',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::CLIENT_HELP])->run($rules);
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
