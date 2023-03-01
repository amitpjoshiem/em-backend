<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Requests;

use App\Containers\AppSection\Otp\Data\Transporters\ChangeOtpTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class ChangeOtpRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = ChangeOtpTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'service' => ['nullable', Rule::in(array_keys(config('appSection-otp.otp_services')))],
            'code'    => ['required_if:service,google'],
        ];
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
