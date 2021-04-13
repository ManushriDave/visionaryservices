<?php

namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum;

final class MailType extends Enum implements LocalizedEnum
{
    const NEW_EMAIL = 5;
    const REGISTERED = 0;
    const ACCEPTED = 1;
    const REJECTED = 2;
    const ON_HOLD = 3;
    const INTERVIEW = 4;
    const CUSTOM = 6;
}
