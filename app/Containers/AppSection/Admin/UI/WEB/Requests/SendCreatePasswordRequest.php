<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\WEB\Requests;

use App\Containers\AppSection\Admin\Data\Enums\AdminPermissionsEnum;
use App\Containers\AppSection\Admin\Data\Transporters\SendCreatePasswordTransporter;
use App\Ship\Parents\Requests\Request;

class SendCreatePasswordRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = SendCreatePasswordTransporter::class;

    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => [AdminPermissionsEnum::ADMIN_SEND_USER_CREATE_PASSWORD],
        'roles'       => '',
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

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'id' => 'required',
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
