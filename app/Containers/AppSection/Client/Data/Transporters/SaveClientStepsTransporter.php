<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Client\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class SaveClientStepsTransporter extends Transporter
{
    public ?string $completed_financial_fact_finder;

    public ?string $investment_and_retirement_accounts;

    public ?string $life_insurance_annuity_and_long_terms_care_policies;

    public ?string $social_security_information;

    public ?string $medicare_details;

    public ?string $property_casualty;
}
