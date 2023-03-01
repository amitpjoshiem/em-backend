<?php

declare(strict_types=1);

namespace App\Containers\AppSection\Salesforce\Data\Enums;

use App\Ship\Parents\Enums\Enum;

class OpportunityStageEnum extends Enum
{
    /** @var string */
    public const PROSPECT = 'prospect';

    /** @var string */
    public const NONE = 'none';

    /** @var string */
    public const APPOINTMENT_1ST = 'appointment_1st';

    /** @var string */
    public const APPOINTMENT_2ND = 'appointment_2nd';

    /** @var string */
    public const APPOINTMENT_3RD = 'appointment_3rd';

    /** @var string */
    public const PLACE_HOLDER_ACCT = 'place_holder_acct';

    /** @var string */
    public const PAPERWORK_SIGNED = 'paperwork_signed';

    /** @var string */
    public const COMMISSION_PAID = 'commission_paid';

    /** @var string */
    public const CONTRACT_DELIVERY_FREE_LOOK_PERIOD = 'contract_delivery_free_look_period';

    /** @var string */
    public const CLOSED_WON = 'closed_won';

    /** @var string */
    public const CLOSED_LOST  = 'closed_lost';

    /** @var string */
    public const CLOSED  = 'closed';

    /**
     * @psalm-suppress InvalidReturnType, InvalidReturnStatement
     */
    public static function values(): array
    {
        return [
            self::NONE,
            self::APPOINTMENT_1ST,
            self::APPOINTMENT_2ND,
            self::APPOINTMENT_3RD,
            self::PLACE_HOLDER_ACCT,
            self::PAPERWORK_SIGNED,
            self::COMMISSION_PAID,
            self::CONTRACT_DELIVERY_FREE_LOOK_PERIOD,
            self::CLOSED_WON,
            self::CLOSED_LOST,
        ];
    }

    public static function titles(): array
    {
        return [
            self::NONE                                  => 'None',
            self::PROSPECT                              => 'Prospect',
            self::APPOINTMENT_1ST                       => '1st Appointment',
            self::APPOINTMENT_2ND                       => '2nd Appointment',
            self::APPOINTMENT_3RD                       => '3rd Appointment',
            self::PLACE_HOLDER_ACCT                     => 'Place Holder Acct',
            self::PAPERWORK_SIGNED                      => 'Paperwork Signed',
            self::COMMISSION_PAID                       => 'Commission Paid',
            self::CONTRACT_DELIVERY_FREE_LOOK_PERIOD    => 'Contract delivery/Free look period',
            self::CLOSED_WON                            => 'Closed Won',
            self::CLOSED_LOST                           => 'Closed Lost',
        ];
    }

    public static function getTitle(string $stage): string
    {
        $stages = self::titles();

        return $stages[$stage];
    }

    public static function getValue(string $title): string
    {
        $titles = array_flip(self::titles());

        return $titles[$title];
    }
}
