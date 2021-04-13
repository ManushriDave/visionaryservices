<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Services\NiftyAssistantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SignatureController extends Controller
{
    private $niftyAssistantSvc;

    /**
     * SignatureController constructor.
     * @param $niftyAssistantSvc
     */
    public function __construct(NiftyAssistantService $niftyAssistantSvc)
    {
        $this->niftyAssistantSvc = $niftyAssistantSvc;
    }

    public function index()
    {
        $signatures = $this->niftyAssistantSvc->signatures();
        return view('admin.signatures.index', [
            'signatures' => $signatures,
        ]);
    }

    public function download($id): StreamedResponse
    {
        $signature = $this->niftyAssistantSvc->getSignature($id);
        return Storage::download($signature->signature);
    }
}
