<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Data\Transporters\VerifyPhoneTransporter;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateAdminRequest.
 */
class VerifyPhoneRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = VerifyPhoneTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    public function rules(): array
    {
        return [
            'code' => 'required',
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
