<?php

namespace App\Repositories;

use App\Models\ChatRoom;
use App\Repositories\Interfaces\ChatRoomRepositoryInterface;

class ChatRoomRepository implements ChatRoomRepositoryInterface
{
    public function get(int $id): ChatRoom
    {
        return ChatRoom::find($id);
    }

    public function getAll()
    {
        return ChatRoom::with('user', 'nifty_assistant')->get();
    }
}
