<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static ADD_RESOURCES()
 * @method static static REMOVE_RESOURCES()
 * @method static static NORMAL()
 * @method static static AVAILABILITY()
 */
final class ProfileUpdateType extends Enum
{
    const ADD_RESOURCES = 0;
    const NORMAL = 1;
    const REMOVE_RESOURCES = 2;
    const AVAILABILITY = 3;
}
