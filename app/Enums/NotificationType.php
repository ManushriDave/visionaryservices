<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static AppointmentPlaced()
 * @method static static AppointmentAccepted()
 * @method static static AppointmentRejected()
 */
final class NotificationType extends Enum
{
    const AppointmentPlaced = 0;
    const AppointmentAccepted = 1;
    const AppointmentRejected = 2;
}
