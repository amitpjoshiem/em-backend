<?php

declare(strict_types=1);

namespace App\Containers\AppSection\FixedIndexAnnuities\UI\API\Requests;

use App\Containers\AppSection\FixedIndexAnnuities\Data\Transporters\UpdateInvestmentPackageTransporter;
use App\Containers\AppSection\Media\Data\Enums\MediaCollectionEnum;
use App\Containers\AppSection\Media\Tasks\MediaAttributesValidationRulesMergerTask;
use App\Ship\Parents\Requests\Request;

class UpdateInvestmentPackageRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     */
    protected ?string $transporter = UpdateInvestmentPackageTransporter::class;

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
        $rules = [
            'id'      => 'required|exists:investment_packages,id',
            'name'    => 'string',
        ];

        return $merger->setAllowedCollectionTypes([MediaCollectionEnum::INVESTMENT_PACKAGE])->run($rules);
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
