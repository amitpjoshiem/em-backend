<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class UpdateSettingRequest.
 *
 * @property-read int         $id
 * @property-read string|null $key
 * @property-read string|null $value
 */
class UpdateSettingRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => 'admin',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'id',
    ];

    public function rules(): array
    {
        return [
            'id'    => 'required|exists:settings,id',
            'key'   => 'sometimes|string|max:190',
            'value' => 'sometimes|string|max:190',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
