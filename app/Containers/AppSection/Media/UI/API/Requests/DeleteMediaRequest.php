<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Media\UI\API\Requests;

use App\Containers\AppSection\Media\Data\Transporters\DeleteMediaTransporter;
use App\Ship\Parents\Requests\Request;

class DeleteMediaRequest extends Request
{
    protected ?string $transporter = DeleteMediaTransporter::class;

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

    public function rules(): array
    {
        return [
            'id' => 'required|exists:media,id',
        ];
    }

    /**
     * Check if the authenticated user actually has the authority to change a given resource.
     */
    public function authorize(): bool
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
