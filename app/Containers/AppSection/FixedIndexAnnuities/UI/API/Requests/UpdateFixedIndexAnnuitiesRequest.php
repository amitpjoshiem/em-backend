<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Enums\TaxQualificationEnum;
use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\UpdateFixedIndexAnnuitiesTransporter;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

class UpdateFixedIndexAnnuitiesRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateFixedIndexAnnuitiesTransporter::class;

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
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules =  [
            'id'                 => 'required',
            'name'               => 'string',
            'insurance_provider' => 'string',
            'tax_qualification'  => ['string', Rule::in(TaxQualificationEnum::values())],
            'agent_rep_code'     => 'string',
            'license_number'     => 'numeric',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::FIXED_INDEX_ANNUITIES])->run($rules);
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
