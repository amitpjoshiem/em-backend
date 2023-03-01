<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Requests;

use App\Containers\AppSection\Blueprint\Data\Transporters\SaveBlueprintMonthlyIncomeTransporter;
use App\Ship\Parents\Requests\Request;

class SaveBlueprintMonthlyIncomeRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = SaveBlueprintMonthlyIncomeTransporter::class;

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
            'member_id'             => 'required',
            'current_member'        => 'numeric|nullable',
            'current_spouse'        => 'numeric|nullable',
            'current_pensions'      => 'numeric|nullable',
            'current_rental_income' => 'numeric|nullable',
            'current_investment'    => 'numeric|nullable',
            'future_member'         => 'numeric|nullable',
            'future_spouse'         => 'numeric|nullable',
            'future_pensions'       => 'numeric|nullable',
            'future_rental_income'  => 'numeric|nullable',
            'future_investment'     => 'numeric|nullable',
            'tax'                   => 'numeric|nullable',
            'ira_first'             => 'numeric|nullable',
            'ira_second'            => 'numeric|nullable',
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
