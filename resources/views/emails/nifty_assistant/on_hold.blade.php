@component('mail::message')
# {{ config('app.name') }} Application Unsuccessful!

{{ mail_template(\App\Enums\MailType::ON_HOLD)->heading }}

@component('mail::panel')
Reason for Hold : <b>{{ $reason }}</b>
@endcomponent

{!! mail_template(\App\Enums\MailType::ON_HOLD)->content !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
