<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests;

use App\Containers\AppSection\Member\Data\Transporters\ConfirmMemberAssetsAccountsTransporter;
use App\Ship\Parents\Requests\Request;

class ConfirmMemberAssetsAccountsRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = ConfirmMemberAssetsAccountsTransporter::class;

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
        'member_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'member_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'member_id'    => 'required',
        ];
    }
}
