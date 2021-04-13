<?php

use App\Enums\MailType;

return [

    MailType::class => [
        MailType::REGISTERED => 'On-Register Email',
        MailType::ACCEPTED   => 'On-Accepted Email',
        MailType::REJECTED   => 'On-Rejected Email',
        MailType::ON_HOLD    => 'On-Hold Email',
        MailType::INTERVIEW  => 'Interview Email',
    ],

];
