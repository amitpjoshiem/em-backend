<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Documentation\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Traits\RequestWithoutRulesTrait;

/**
 * Class DocumentationRequest.
 */
class DocumentationRequest extends Request
{
    use RequestWithoutRulesTrait;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
