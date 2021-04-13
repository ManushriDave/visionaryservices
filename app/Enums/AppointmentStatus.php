<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static ACCEPTED()
 * @method static static ONGOING()
 * @method static static COMPLETED()
 * @method static static REJECTED()
 */
final class AppointmentStatus extends Enum
{
    const PENDING = 0;
    const ACCEPTED = 1;
    const ONGOING = 2;
    const COMPLETED = 3;
    const REJECTED = 4;
}
