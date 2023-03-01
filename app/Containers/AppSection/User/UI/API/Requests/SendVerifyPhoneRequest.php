<?php

declare(strict_types=1);

namespace App\Containers\AppSection\User\UI\API\Requests;

use App\Containers\AppSection\User\Data\Transporters\SendVerifyPhoneTransporter;
use App\Containers\AppSection\User\UI\API\Requests\Rules\PhoneSendVerifyRule;
use App\Ship\Parents\Requests\Request;

/**
 * Class CreateAdminRequest.
 */
class SendVerifyPhoneRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = SendVerifyPhoneTransporter::class;

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
            'phone' => ['required', new PhoneSendVerifyRule()],
        ];
    }

    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
