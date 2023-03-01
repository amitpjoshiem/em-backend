<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsIncome\UI\API\Requests;

use App\Containers\AppSection\AssetsIncome\Data\Enums\GroupsEnum;
use App\Containers\AppSection\AssetsIncome\Data\Transporters\CheckRowTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class CheckRowRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CheckRowTransporter::class;

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
            'member_id' => 'required|exists:members,id',
            'group'     => ['required', Rule::in(GroupsEnum::toValues())],
            'row'       => 'required|string',
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
