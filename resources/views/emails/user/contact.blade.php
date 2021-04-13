@component('mail::message')
# New Contact By {{ $data['name'] }}!
<br><br>
Customer's Email Address : {{ $data['email'] }}

@if (array_key_exists('subject', $data))
Subject : {{ $data['subject'] }}
@endif

@component('mail::panel')
    Message :
    <br><br>
    {{ $data['message'] }}
@endcomponent


@component('mail::button', ['url' => 'mailto::'.$data['email']])
    Email Customer
@endcomponent

Thanks,<br>
{{ config('app.name') }} System.
@endcomponent
