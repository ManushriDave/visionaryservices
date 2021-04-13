<?php

namespace App\Repositories\Interfaces;

use App\Models\ChatRoom;

interface ChatRoomRepositoryInterface
{
    public function get(int $id): ChatRoom;

    public function getAll();
}
