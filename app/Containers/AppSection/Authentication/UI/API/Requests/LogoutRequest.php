<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authentication\UI\API\Requests;

use App\Containers\AppSection\Authentication\Data\Transporters\LogoutTransporter;
use App\Ship\Parents\Requests\Request;
use App\Ship\Parents\Traits\RequestWithoutRulesTrait;

class LogoutRequest extends Request
{
    use RequestWithoutRulesTrait;

    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = LogoutTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

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
