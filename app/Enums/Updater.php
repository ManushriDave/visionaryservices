<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static updateProfilePassword()
 * @method static static updateProfileBilling()
 * @method static static OptionThree()
 */
final class Updater extends Enum
{
    const updateProfilePassword = 'chg_profile_pwd';
    const updateProfileBilling = 'chg_profile_billing';
    const updateProfileBasic = 'chg_profile_basic';
    const acceptNiftyAssistant = 'accept_nifty_assistant';
    const rejectNiftyAssistant = 'reject_nifty_assistant';
}
