<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Traits\RequestWithoutRulesTrait;

/**
 * Class GetAllUsersRequest.
 */
class GetAllUsersRequest extends Request
{
    use RequestWithoutRulesTrait;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => [],
        'roles'       => [],
    ];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
