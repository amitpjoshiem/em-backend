<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Yodlee\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

class YodleeCategoryRuleTransporter extends Transporter
{
    public ?int $categoryId;

    public ?int $priority;

    public ?string $source;

    /**
     * @var array<YodleeCategoryRuleClauseTransporter>|null
     */
    public ?array $ruleClause;
}
