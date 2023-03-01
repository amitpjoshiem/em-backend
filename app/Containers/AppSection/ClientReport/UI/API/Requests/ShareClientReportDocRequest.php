<?php

declare(strict_types=1);

namespace App\Containers\AppSection\ClientReport\UI\API\Requests;

use App\Containers\AppSection\ClientReport\Data\Transporters\ShareClientReportDocTransporter;
use App\Containers\AppSection\ClientReport\Exceptions\CantFindClientReportDocException;
use App\Containers\AppSection\ClientReport\UI\API\Requests\Rules\EmailExistsValidationRule;
use App\Ship\Parents\Requests\Request;

class ShareClientReportDocRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = ShareClientReportDocTransporter::class;

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
            throw new CantFindClientReportDocException();
        }

        return [
            'doc_id'                => 'required|exists:client_reports_docs,id',
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
