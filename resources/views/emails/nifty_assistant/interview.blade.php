@component('mail::message')
# {{ config('app.name') }} Interview Details!

{{ mail_template(\App\Enums\MailType::INTERVIEW)->heading_text }}

@component('mail::panel')
    Find below your {{ config('app.name') }} Interview Details :
    <br><br>
    Date & Time : {{ $data['date'] }}<br>
    Comments : {{ $data['comments'] }}
@endcomponent
{!! mail_template(\App\Enums\MailType::INTERVIEW)->content !!}
@component('mail::button', ['url' => mail_template(\App\Enums\MailType::INTERVIEW)->btn_link])
    {{ mail_template(\App\Enums\MailType::INTERVIEW)->btn_text }}
@endcomponent

Thanks,<br><br>
<img width="200" src="http://visionaryservices.test/assets/common/images/1logo.png"  alt="NiftyAssistance Logo"/>
@endcomponent
