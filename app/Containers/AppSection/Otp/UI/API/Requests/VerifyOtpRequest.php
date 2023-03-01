<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Otp\UI\API\Requests;

use App\Containers\AppSection\Otp\Data\Transporters\VerifyOtpTransporter;
use App\Ship\Parents\Requests\Request;

class VerifyOtpRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = VerifyOtpTransporter::class;

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
            'code' => 'required|string:' . config('number_of_digits'),
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
