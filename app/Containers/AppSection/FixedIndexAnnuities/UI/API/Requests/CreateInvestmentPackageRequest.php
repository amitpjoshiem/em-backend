<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\CreateInvestmentPackageTransporter;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;

class CreateInvestmentPackageRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = CreateInvestmentPackageTransporter::class;

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
        'fixed_index_annuities_id',
    ];

    /**
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'fixed_index_annuities_id',
    ];

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(MediaAttributesValidationRulesMergerTask $merger): array
    {
        $rules = [
            'fixed_index_annuities_id'      => 'required|exists:fixed_index_annuities,id',
            'name'                          => 'required|string',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::INVESTMENT_PACKAGE])->run($rules, true);
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
