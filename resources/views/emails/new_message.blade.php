@component('mail::message')
# New Message Received

A new message is sent by a {{ $user }}.

@component('mail::button', ['url' => route('niftyassistant.chat.index')])
    Click to View Chats
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
