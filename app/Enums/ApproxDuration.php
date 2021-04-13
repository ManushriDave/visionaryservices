<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static One()
 * @method static static TwoToThree()
 * @method static static FourPlus()
 */
final class ApproxDuration extends Enum
{
    const One = 0;
    const TwoToThree = 1;
    const FourPlus = 2;
}
