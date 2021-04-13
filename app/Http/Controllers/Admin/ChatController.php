<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\ChatService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $chatSvc;

    /**
     * ChatController constructor.
     * @param $chatSvc
     */
    public function __construct(ChatService $chatSvc)
    {
        $this->chatSvc = $chatSvc;
    }

    public function index()
    {
        $chat_rooms = $this->chatSvc->getAll();
        return view('admin.chats.index', [
            'chat_rooms' => $chat_rooms,
        ]);
    }

    public function show($id)
    {
        $chat_room = $this->chatSvc->getRoom($id);
        return view('admin.chats.show', [
            'chat_room' => $chat_room,
        ]);
    }
}
