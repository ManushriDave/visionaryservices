<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\AssistantTypeService;
use Illuminate\Http\Request;

class AssistantTypeController extends Controller
{
    private AssistantTypeService $assistantTypeSvc;

    /**
     * AssistantTypeController constructor.
     * @param $assistantTypeSvc
     */
    public function __construct(AssistantTypeService $assistantTypeSvc)
    {
        $this->assistantTypeSvc = $assistantTypeSvc;
    }

    public function index()
    {
        $assistant_types = $this->assistantTypeSvc->getAll();
        return view('admin.assistant_types.index', [
            'assistant_types' => $assistant_types,
        ]);
    }

    public function show($id)
    {
        $assistant_type = $this->assistantTypeSvc->get($id);
        return view('admin.assistant_types.show', [
            'assistant_type' => $assistant_type,
        ]);
    }

    public function edit($id)
    {
        $assistant_type = $this->assistantTypeSvc->get($id);
        return view('admin.assistant_types.edit', [
            'assistant_type' => $assistant_type,
        ]);
    }

    public function update($id, Request $request)
    {
        $this->assistantTypeSvc->update($id, $request->except('_token', '_method'));
        return redirect(route('admin.assistant_types.edit', $id));
    }

    public function create()
    {
        return view('admin.assistant_types.create');
    }

    public function store(Request $request)
    {
        $this->assistantTypeSvc->store($request->except('_token', '_method'));
        return redirect(route('admin.assistant_types.index'));
    }

    public function destroy($id)
    {
        $this->assistantTypeSvc->delete($id);
        return redirect(route('admin.assistant_types.index'));
    }
}
