<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * @var Request
     */
    private $request;

    /**
     * IndexController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        if ($request->hasHeader('nifty')) {
            $middleware = ['auth:niftyassistant-api', 'scope:is-nifty'];
        } else {
            $middleware = ['auth:api', 'scope:is-user'];
        }
        $this->middleware($middleware);
    }

    public function index()
    {
        return $this->request->user();
    }
}
