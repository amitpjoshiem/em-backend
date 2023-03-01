<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests;

use App\Containers\AppSection\Member\Data\Transporters\GetAllMembersTransporter;
use App\Containers\AppSection\Member\Models\Member;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class GetAllMembersRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = GetAllMembersTransporter::class;

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
        //        'member_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        //        'member_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'status' => ['string', Rule::in([Member::ACTIVE_STATUS, Member::INACTIVE_STATUS])],
        ];
    }
}
