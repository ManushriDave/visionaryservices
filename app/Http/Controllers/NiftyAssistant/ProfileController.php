<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Services\FileService;
use App\Services\NiftyAssistantService;
use App\Services\NiftyProfileService;
use Auth;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $niftyAssistantSvc;
    private $niftyProfileSvc;
    private $fileSvc;

    /**
     * ProfileController constructor.
     * @param NiftyAssistantService $niftyAssistantSvc
     * @param NiftyProfileService $niftyProfileSvc
     * @param FileService $fileSvc
     */
    public function __construct(
        NiftyAssistantService $niftyAssistantSvc,
        NiftyProfileService $niftyProfileSvc,
        FileService $fileSvc
    ) {
        $this->niftyAssistantSvc = $niftyAssistantSvc;
        $this->niftyProfileSvc = $niftyProfileSvc;
        $this->fileSvc = $fileSvc;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $nifty = $this->niftyAssistantSvc->get(Auth::id());
        return view('niftyassistant.profile.index', [
            'nifty'            => $nifty,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'avatar_file'       => 'mimes:jpeg,jpg,png,gif',
            'resources_files.*' => 'mimes:png,mp4,jpeg,jpg,ogg',
        ]);
        $data = $request->except('_token', '_method');

        if ($request->filled('avatar')) {
            $folderPath = public_path('storage/avatars/');
            $image_parts = explode(";base64,", $request->input('avatar'));
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1], true);
            $file = uniqid() . '.' . $image_type;
            file_put_contents($folderPath . $file, $image_base64);
            $data['avatar'] = 'avatars/'.$file;
        }

        $this->niftyProfileSvc->update($id, $data);
        return redirect(route('niftyassistant.profile.index'));
    }
}
