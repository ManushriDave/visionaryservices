<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\OtherTaskService;
use Illuminate\Http\Request;

class OtherTaskController extends Controller
{
    private $otherTaskSvc;

    /**
     * OtherTaskController constructor.
     * @param $otherTaskSvc
     */
    public function __construct(OtherTaskService $otherTaskSvc)
    {
        $this->otherTaskSvc = $otherTaskSvc;
    }

    public function update($id, Request $request)
    {
        $this->otherTaskSvc->update($id, $request->except('_token', '_method'));
        return redirect()->back();
    }
}
