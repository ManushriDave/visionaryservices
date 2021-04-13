<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREDIT()
 * @method static static DEBIT()
 * @method static static OptionThree()
 */
final class TransactionType extends Enum
{
    const CREDIT = 0;
    const DEBIT = 1;
}
