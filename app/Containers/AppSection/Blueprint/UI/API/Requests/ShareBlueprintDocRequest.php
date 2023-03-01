<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Requests;

use App\Containers\AppSection\Blueprint\Data\Transporters\ShareBlueprintDocTransporter;
use App\Containers\AppSection\Blueprint\Exceptions\DocumentNotFountException;
use App\Containers\AppSection\Blueprint\UI\API\Requests\Rules\EmailExistsValidationRule;
use App\Ship\Parents\Requests\Request;

class ShareBlueprintDocRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = ShareBlueprintDocTransporter::class;

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
        'doc_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'doc_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $docId = $this->getInputByKey('doc_id');

        if ($docId === null) {
            throw new DocumentNotFountException();
        }

        return [
            'doc_id'                => 'required|exists:blueprint_docs,id',
            'emails'                => 'required|array',
            'emails.*'              => new EmailExistsValidationRule($docId),
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
