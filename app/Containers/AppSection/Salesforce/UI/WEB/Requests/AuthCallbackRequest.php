<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\UI\WEB\Requests;

use App\Containers\AppSection\Salesforce\Data\Transporters\AuthCallbackTransporter;
use App\Ship\Parents\Requests\Request;

class AuthCallbackRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = AuthCallbackTransporter::class;

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
        'state',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        //         'user_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'code'   => 'required',
            'state'  => 'required',
        ];
    }
}
