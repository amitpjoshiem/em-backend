<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Blueprint\UI\API\Requests\Rules;

use App\Containers\AppSection\Blueprint\Models\BlueprintDoc;
use App\Containers\AppSection\Blueprint\Tasks\FindBlueprintDocByIdTask;
use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use Illuminate\Contracts\Validation\Rule;

class EmailExistsValidationRule implements Rule
{
    public function __construct(private int $docId)
    {
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @psalm-param mixed $value
     */
    public function passes($attribute, $value): bool
    {
        /** @var BlueprintDoc $doc */
        $doc           = app(FindBlueprintDocByIdTask::class)->withRelations(['member', 'member.spouse'])->run($this->docId);
        $isUserEmail   = app(UserRepository::class)->count(['email' => $value]) > 0;
        $isMemberEmail = $doc->member->email          === $value;
        $isSpouseEmail = $doc->member->spouse?->email === $value;

        return !(!$isUserEmail && !$isMemberEmail && !$isSpouseEmail);
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The :attribute must belong to member or spouse or advisors';
    }
}
