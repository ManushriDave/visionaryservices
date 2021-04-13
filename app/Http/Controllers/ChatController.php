<?php

namespace App\Http\Controllers;

use App\Contracts\Controller;
use App\Events\MessageSent;
use App\Models\ChatRoom;
use App\Models\Message;
use App\Services\ChatService;
use App\Services\NiftyAssistantService;
use App\Services\UserService;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function index(Request $request, $id, $token)
    {
        $room = collect();
        $room->put('id', $id);
        $room->put('token', $token);
        $is_nifty = false;
        if (Str::contains($request->fullUrl(), '?nifty')) {
            $is_nifty = true;
        }
        $room->put('is_nifty', $is_nifty);
        return view('chat.index', [
            'room' => $room,
        ]);
    }
}
