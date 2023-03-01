<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Authorization\Data\Enums;

use App\Ship\Parents\Enums\Enum;
use Closure;

/**
 * @method static self advisor()
 * @method static self client()
 * @method static self lead()
 * @method static self ceo()
 * @method static self admin()
 * @method static self assistant()
 * @method static self support()
 *
 * @property-read string $value
 */
class RolesEnum extends Enum
{
    /** @var string */
    public const ADMIN    = 'admin';

    /** @var string */
    public const CEO    = 'ceo';

    /** @var string */
    public const ADVISOR  = 'advisor';

    /** @var string */
    public const CLIENT  = 'client';

    /** @var string */
    public const ASSISTANT  = 'assistant';

    /** @var string */
    public const LEAD  = 'lead';

    /** @var string */
    public const SUPPORT  = 'support';

    protected static function values(): Closure
    {
        return fn (string $name): string => mb_strtolower($name);
    }

    /**
     * An example label return 'Investor Role'.
     */
    protected static function labels(): Closure
    {
        return fn (string $name): string => sprintf('%s Role', ucfirst($name));
    }
}
