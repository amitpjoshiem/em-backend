<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Containers\AppSection\User\Data\Transporters\UpdateUserTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUserRequest.
 *
 * @property-read int    $id
 * @property-read string $username
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $avatar
 * @property-read string $company_name
 * @property-read string $data_source
 */
class UpdateUserRequest extends Request
{
    protected ?string $transporter = UpdateUserTransporter::class;

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
        'id',
        'company_id',
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'id',
    ];

    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'id'           => 'required|exists:users,id',
            'username'     => 'string|min:2|max:100|unique:users,username',
            'first_name'   => 'string|min:2|max:100',
            'last_name'    => 'string|min:2|max:100',
            'company_id'   => 'exists:companies,id',
            'data_source'  => Rule::in(array_keys(config('init-container.data_sources'))),
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::AVATAR])->run($rules);
    }

    /**
     * Is this an admin who has access to permission `update-users`
     * or the user is updating his own object (is the owner).
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess|isOwner',
        ]);
    }
}
