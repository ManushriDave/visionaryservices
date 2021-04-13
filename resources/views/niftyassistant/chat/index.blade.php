
@extends('layouts.niftyassistant')

@section('title', 'Nifty-Chat')

@section('content')
    <div class="card col-md-6 mx-auto">
        <div class="card-header">
            <h5 class="card-title">
                Chat with Clients
            </h5>
        </div>
        <div class="card-body">
            <table class="table table-hover table-bordered">
                <thead>
                    <th>Room ID</th>
                    <th>Client</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                @foreach($nifty->rooms as $room)
                    <tr>
                        <td>Room - {{ $room->id }}</td>
                        <td>{{ $room->user->name }}</td>
                        <td>
                            <a href="javascript:void(0)" onclick="window.open('{{ config('app.url') }}/chat/{{ $room->id }}/{{ $nifty->token->token }}?nifty', 'chat-window', 'menubar=1,resizable=1,width=350,height=450')" class="btn btn-sm btn-info">
                                Join Room - {{ $room->id }}
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
