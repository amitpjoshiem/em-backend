<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Localization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Traits\RequestWithoutRulesTrait;

class GetAllLocalizationsRequest extends Request
{
    use RequestWithoutRulesTrait;

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

    ];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
