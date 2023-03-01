<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Requests;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\UpdateAssetsConsolidationsTransporter;
use App\Ship\Parents\Requests\Request;

class UpdateAssetsConsolidationsRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateAssetsConsolidationsTransporter::class;

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
            'id'                    => 'required',
            'name'                  => 'string|nullable',
            'amount'                => 'numeric|nullable',
            'management_expense'    => 'numeric|nullable|between:0,100',
            'turnover'              => 'numeric|nullable|between:0,100',
            'trading_cost'          => 'numeric|nullable|between:0,100',
            'wrap_fee'              => 'numeric|nullable|between:0,100',
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
