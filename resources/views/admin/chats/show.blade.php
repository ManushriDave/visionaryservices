
@extends('layouts.admin')

@section('title', 'Chats')

@section('content')
    <div class="chatbox active w-100" style="position: relative">
        <div class="card chat dz-chat-history-box">
        <div class="card-header chat-list-header text-center">
            <div>
                <h6 class="mb-1">Chat Between {{ $chat_room->user->name }} & {{ $chat_room->nifty_assistant->getName() }}</h6>
            </div>
        </div>
        <div class="card-body msg_card_body dz-scroll" id="DZ_W_Contacts_Body3">
            @foreach($chat_room->messages as $message)
                @php
                    $user = $message->from_user ? $message->user() : $message->nifty_assistant();
                @endphp
                <div class="d-flex justify-content-{{ !$message->from_user ? 'start' : 'end' }} mb-4">
                    <div class="img_cont_msg">
                        <img src="{{ $user->avatar }}" class="rounded-circle user_img_msg" alt=""/>
                    </div>
                    <div class="msg_cotainer{{ !$message->from_user ? '_send' : 'end' }}">
                        {{ $message->message }}
                        <span class="msg_time">{{ $message->created_at->toDayDateTimeString() }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        </div>
    </div>
@endsection

