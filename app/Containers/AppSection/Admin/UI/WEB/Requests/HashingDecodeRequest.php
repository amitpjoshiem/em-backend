<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Admin\UI\WEB\Requests;

use App\Containers\AppSection\Admin\Data\Transporters\HashingDecodeTransporter;
use App\Ship\Parents\Requests\Request;

class HashingDecodeRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = HashingDecodeTransporter::class;

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
        'hashed',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        //        'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'hashed' => 'numeric|required',
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
