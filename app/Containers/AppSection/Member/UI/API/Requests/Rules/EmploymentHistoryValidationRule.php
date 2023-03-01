<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Member\UI\API\Requests\Rules;

use App\Containers\AppSection\Member\Models\MemberEmploymentHistory;
use Illuminate\Contracts\Validation\Rule;

class EmploymentHistoryValidationRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @psalm-param mixed $value
     */
    public function passes($attribute, $value): bool
    {
        if (empty($value[MemberEmploymentHistory::COMPANY_NAME])) {
            return true;
        }

        return isset($value[MemberEmploymentHistory::OCCUPATION]) &&
            isset($value[MemberEmploymentHistory::YEARS]);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must contain all three values';
    }
}
