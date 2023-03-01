<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Enums\TaxQualificationEnum;
use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\CreateFixedIndexAnnuitiesTransporter;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class CreateFixedIndexAnnuitiesRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CreateFixedIndexAnnuitiesTransporter::class;

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
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'member_id'          => 'required|exists:members,id',
            'name'               => 'required|string',
            'insurance_provider' => 'required|string',
            'tax_qualification'  => ['required', 'string', Rule::in(TaxQualificationEnum::values())],
            'agent_rep_code'     => 'string',
            'license_number'     => 'numeric',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::FIXED_INDEX_ANNUITIES])->run($rules, true);
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
