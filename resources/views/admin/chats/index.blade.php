@extends('layouts.admin')

@section('title', 'Chats')

@section('head')
    @include('admin.head.datatable')
@endsection

@section('content')
    <div class="col-lg-8 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">All Chat Rooms</h4>
            </div>
            <div class="card-body">
                <table class="table display">
                    <thead>
                        <th>User</th>
                        <th>Nifty</th>
                        <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($chat_rooms as $chat_room)
                            <tr>
                                <td>{{ $chat_room->user->name  }}</td>
                                <td>{{ $chat_room->nifty_assistant->getName() }}</td>
                                <td class="text-center">
                                    <a class="btn btn-info btn-xs" href="{{ route('admin.chats.show', $chat_room->id) }}">
                                        View Chats
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('admin.scripts.datatable')
@endsection
