<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static PENDING()
 * @method static static APPROVED()
 * @method static static ON_HOLD()
 * @method static static REJECTED()
 */
final class NiftyStatus extends Enum
{
    const PENDING = 0;
    const APPROVED = 1;
    const ON_HOLD = 2;
    const REJECTED = 3;
}
