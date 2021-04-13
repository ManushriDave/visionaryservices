@component('mail::message')
# {{ config('app.name') }} Application Received!

Hi {{ $nifty->name }},<br><br>

{!! mail_template(\App\Enums\MailType::REGISTERED)->content !!}

@component('mail::button', ['url' => mail_template(\App\Enums\MailType::REGISTERED)->btn_link])
    {{ mail_template(\App\Enums\MailType::REGISTERED)->btn_text }}
@endcomponent

<img width="200" src="http://visionaryservices.test/assets/common/images/1logo.png"  alt="NiftyAssistance Logo"/>
@endcomponent
