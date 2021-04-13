<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Services\NiftyAssistantService;
use Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class ChatController extends Controller
{
    private $niftyAssistantSvc;

    /**
     * ChatController constructor.
     * @param $niftyAssistantSvc
     */
    public function __construct(NiftyAssistantService $niftyAssistantSvc)
    {
        $this->niftyAssistantSvc = $niftyAssistantSvc;
    }

    public function index()
    {
        $nifty = $this->niftyAssistantSvc->get(Auth::id());
        return view('niftyassistant.chat.index', [
            'nifty' => $nifty,
        ]);
    }
}
