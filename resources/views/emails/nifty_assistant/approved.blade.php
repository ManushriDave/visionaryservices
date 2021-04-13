@component('mail::message')
# {{ config('app.name') }} Application Successful!

{{ mail_template(\App\Enums\MailType::ACCEPTED)->heading_text }}

@component('mail::panel')
    Find below your {{ config('app.name') }} Account Details :
    <br><br>
    Email : {{ $nifty_assistant->email }}<br>
    Password : {{ $password }}
@endcomponent

{!! mail_template(\App\Enums\MailType::ACCEPTED)->content !!}

@component('mail::button', ['url' => mail_template(\App\Enums\MailType::ACCEPTED)->btn_link])
    {{ mail_template(\App\Enums\MailType::ACCEPTED)->btn_text }}
@endcomponent

Thanks,<br><br>
<img width="200" src="http://visionaryservices.test/assets/common/images/1logo.png"  alt="NiftyAssistance Logo"/>
@endcomponent
