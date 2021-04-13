@extends('layouts.chat')
@section('head')
    <style>
        .js-chat-window {
            height: 70vh;
        }
    </style>
@endsection
@section('content')
    <chats :room="{{ $room }}"></chats>
@endsection
