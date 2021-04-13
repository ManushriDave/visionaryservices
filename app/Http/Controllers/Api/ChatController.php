<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Services\ChatService;
use App\Services\NiftyAssistantService;
use App\Services\UserService;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    private $chatSvc;
    /**
     * @var Request
     */
    private $request;
    private $niftyAssistantSvc;
    private $userSvc;

    /**
     * ChatController constructor.
     * @param Request $request
     * @param ChatService $chatSvc
     * @param NiftyAssistantService $niftyAssistantSvc
     * @param UserService $userSvc
     */

    public function __construct(
        Request $request,
        ChatService $chatSvc,
        NiftyAssistantService $niftyAssistantSvc,
        UserService $userSvc
    ) {
        if ($request->has('nifty') || $request->hasHeader('nifty')) {
            $this->middleware('auth:niftyassistant-api');
        } else {
            $this->middleware('auth:api');
        }
        $this->chatSvc = $chatSvc;
        $this->niftyAssistantSvc = $niftyAssistantSvc;
        $this->userSvc = $userSvc;
        $this->request = $request;
    }

    public function getRoom($id)
    {
        $room = $this->chatSvc->getRoom($id);

        $client = $room->user;
        $nifty = $room->nifty_assistant;

        if ($this->request->has('nifty') || $this->request->hasHeader('nifty')) {
            $user = $this->niftyAssistantSvc->get($this->request->user()->id, true);
            $user['is_nifty'] = false;
            $user['user_b'] = $client;
        } else {
            $user = $this->userSvc->get($this->request->user()->id);
            $user['is_nifty'] = true;
            $nifty['name'] = $nifty->getName();
            $user['user_b'] = $nifty;
        }

        if (!$user->canJoinRoom($id)) {
            return 'UnAuthorized';
        }

        $user['token'] = $user->token->token;
        return $user;
    }

    public function storeRoom(Request $request): int
    {
        $data = [
            'user_id'            => $request->user()->id,
            'nifty_assistant_id' => $request->input('nifty_assistant_id'),
        ];
        $chat = $this->chatSvc->storeRoom($data);
        return $chat->id;
    }

    public function sendMessage(Request $request): bool
    {
        return $this->chatSvc->storeChat($request->except('_token'));
    }

    public function messages(Request $request, $id)
    {
        if ($this->request->hasHeader('nifty')) {
            $is_nifty = true;
        } else {
            $is_nifty = false;
        }
        $user_id = $request->user()->id;

        return $this->chatSvc->getMessages($id, $is_nifty, $user_id);
    }
}
