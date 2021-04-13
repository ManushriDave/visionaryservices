<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static OptionOne()
 * @method static static OptionTwo()
 * @method static static OptionThree()
 */
final class PersonalAssistantType extends Enum
{
    const OptionOne = 'VIP, CEO, Top executive Personal/Executive assistant';
    const OptionTwo = 'Admin Assistant/Secretary';
    const OptionThree = 'PRO/Government relations/Visas/Immigration';
    const OptionFour = 'Errand runner';
}
