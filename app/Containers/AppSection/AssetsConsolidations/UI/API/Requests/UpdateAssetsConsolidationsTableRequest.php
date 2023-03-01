<?php

declare(strict_types=1);

namespace App\Containers\AppSection\AssetsConsolidations\UI\API\Requests;

use App\Containers\AppSection\AssetsConsolidations\Data\Transporters\UpdateAssetsConsolidationsTableTransporter;
use App\Ship\Parents\Requests\Request;

class UpdateAssetsConsolidationsTableRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateAssetsConsolidationsTableTransporter::class;

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
        'table_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'table_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'table_id'  => 'required',
            'name'      => 'string|nullable',
            'wrap_fee'  => 'numeric|nullable',
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
