@component('mail::message')
# {{ config('app.name') }} Application Unsuccessful!

{{ mail_template(\App\Enums\MailType::REJECTED)->heading_text }}

@component('mail::panel')
Reason for Rejection : <b>{{ $reason }}</b>
@endcomponent

{!! mail_template(\App\Enums\MailType::REJECTED)->content !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
