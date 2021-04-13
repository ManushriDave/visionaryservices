<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Repositories\NiftyGigRepository;
use App\Services\FileService;
use App\Services\NiftyGigService;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NiftyGigController extends Controller
{
    private FileService $fileSvc;
    private NiftyGigRepository $niftyGigRepo;
    private NiftyGigService $niftyGigSvc;

    /**
     * NiftyGigController constructor.
     * @param FileService $fileSvc
     * @param NiftyGigRepository $niftyGigRepo
     * @param NiftyGigService $niftyGigSvc
     */
    public function __construct(
        FileService $fileSvc,
        NiftyGigRepository $niftyGigRepo,
        NiftyGigService $niftyGigSvc
    ) {
        $this->fileSvc = $fileSvc;
        $this->niftyGigRepo = $niftyGigRepo;
        $this->niftyGigSvc = $niftyGigSvc;
    }

    public function index()
    {
        $gigs = $this->niftyGigRepo->getWhere([
            'nifty_assistant_id' => Auth::id(),
        ]);
        return view('niftyassistant.gigs.index', [
            'gigs' => $gigs,
        ]);
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $data = $request->except('_token', '_method');

        if ($request->has('resources')) {
            if ($request->hasFile('resources_files')) {
                $total_size = 0;
                foreach ($request->file('resources_files') as $resources_file) {
                    $total_size += round($resources_file->getSize() / 100000, 2);
                }

                if (!$this->niftyGigSvc->checkSize($id, $total_size)) {
                    flash('Please Check Total Size of All the Files!')->error();
                    return redirect(route('niftyassistant.profile.index'));
                }

                $paths = [];
                foreach ($request->file('resources_files') as $resources_file) {
                    $size = round($resources_file->getSize() / 100000, 2);
                    $file = [];
                    $file['size'] = $size;
                    $file['path'] = $this->fileSvc->uploadFilePublicly($resources_file, 'nifty_resources');
                    $paths[] = $file;
                }
                $data['resources'] = $paths;
            }
            $this->niftyGigSvc->updateResources($id, $data);
            return back();
        }
        unset($data['update_type'], $data['resources_files'], $data['resources']);
        $this->niftyGigRepo->update($id, $data);
        return back();
    }
}
