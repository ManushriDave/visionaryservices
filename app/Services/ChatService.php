<?php

namespace App\Services;

use App\Events\MessageSent;
use App\Mail\NewMessage;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Models\NiftyAssistant;
use App\Models\User;
use App\Repositories\ChatRoomRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class ChatService
{
    private ChatRoomRepository $chatRoomRepo;

    /**
     * ChatService constructor.
     * @param $chatRoomRepo
     */
    public function __construct(ChatRoomRepository $chatRoomRepo)
    {
        $this->chatRoomRepo = $chatRoomRepo;
    }

    public function getAll()
    {
        return $this->chatRoomRepo->getAll();
    }

    public function checkRoom(int $id, int $user_id, bool $is_nifty): bool
    {
        $chatroom = $this->chatRoomRepo->get($id);
        if ($is_nifty) {
            return $chatroom->nifty_assistant_id == $user_id;
        } else {
            return $chatroom->user_id == $user_id;
        }
    }

    public function storeRoom($data): ChatRoom
    {
        $data = [
            'user_id'            => $data['user_id'],
            'nifty_assistant_id' => $data['nifty_assistant_id'],
        ];

        $chatroom = ChatRoom::where($data);

        if ($chatroom->exists()) {
            return $chatroom->first();
        }

        $user = User::find($data['user_id']);
        $nifty = NiftyAssistant::find($data['nifty_assistant_id']);

        Mail::to($nifty)
            ->send(new NewMessage($user->name));

        return ChatRoom::create($data);
    }

    public function storeChat($data): bool
    {
        $chat = collect();

        Message::create([
            'room_id'   => $data['room_id'],
            'message'   => $data['message'],
            'from_user' => $data['from_user'],
        ]);

        $chat->put('message', $data['message']);
        $chat->put('user', $data['user']);
        $chat->put('from_user', $data['from_user']);

        broadcast(new MessageSent(
            $chat,
            $data['room_id']
        ))->toOthers();

        return true;
    }

    public function getRoom($id): ChatRoom
    {
        return ChatRoom::find($id);
    }

    public function getMessages(int $room_id, bool $isNifty, int $user_id)
    {
        $room = $this->getRoom($room_id);

        $client = $room->user;
        $nifty = $room->nifty_assistant;
        $messages = $room->messages;

        foreach ($messages as $message) {
            $is_mine = false;
            if ($isNifty) {
                if (!$message->from_user) {
                    if ($user_id === $nifty->id) {
                        $is_mine = true;
                    }
                }
            } else {
                if ($message->from_user) {
                    if ($user_id === $client->id) {
                        $is_mine = true;
                    }
                }
            }

            if ($message->from_user) {
                $message['user'] = $client;
            } else {
                $message['user'] = $nifty;
            }
            $message['is_mine'] = $is_mine;
            $message['time'] = Carbon::parse($message->created_at)->diffForHumans();
        }
        return $messages;
    }
}
