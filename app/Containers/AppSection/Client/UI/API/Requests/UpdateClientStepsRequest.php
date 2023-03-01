<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\UI\API\Requests;

use App\Containers\AppSection\Client\Data\Enums\ClientDocumentsEnum;
use App\Containers\AppSection\Client\Data\Transporters\SaveClientStepsTransporter;
use App\Containers\AppSection\Client\Models\Client;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateClientStepsRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = SaveClientStepsTransporter::class;

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
        // 'id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        // 'id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [];
        foreach (ClientDocumentsEnum::values() as $step) {
            $rules[$step] = ['string', Rule::in([
                Client::NOT_COMPLETED_STEP,
                Client::NO_DOCUMENTS_STEP,
                Client::COMPLETED_STEP,
            ])];
        }

        return $rules;
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
