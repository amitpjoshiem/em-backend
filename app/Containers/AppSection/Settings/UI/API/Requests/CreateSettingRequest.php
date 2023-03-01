<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Settings\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

class CreateSettingRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => 'admin',
    ];

    public function rules(): array
    {
        return [
            'key'   => 'required|string|max:190',
            'value' => 'required|string|max:190',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
