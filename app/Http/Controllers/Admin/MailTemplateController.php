<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Repositories\MailTemplateRepository;
use App\Repositories\NiftyAssistantRepository;
use App\Services\MailTemplateService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MailTemplateController extends Controller
{
    private MailTemplateRepository $mailTemplateRepo;
    private MailTemplateService $mailTemplateSvc;
    private NiftyAssistantRepository $niftyAssistantRepo;

    /**
     * MailTemplateController constructor.
     * @param MailTemplateRepository $mailTemplateRepo
     * @param MailTemplateService $mailTemplateSvc
     * @param NiftyAssistantRepository $niftyAssistantRepo
     */
    public function __construct(
        MailTemplateRepository $mailTemplateRepo,
        MailTemplateService $mailTemplateSvc,
        NiftyAssistantRepository $niftyAssistantRepo
    ) {
        $this->mailTemplateRepo = $mailTemplateRepo;
        $this->mailTemplateSvc = $mailTemplateSvc;
        $this->niftyAssistantRepo = $niftyAssistantRepo;
    }

    public function index()
    {
        $mail_templates = $this->mailTemplateRepo->getAll();
        return view('admin.mail-templates.index', [
            'mail_templates' => $mail_templates,
        ]);
    }

    public function edit($id)
    {
        $mail_template = $this->mailTemplateRepo->get($id);
        return view('admin.mail-templates.edit', [
            'mail_template' => $mail_template,
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
            'subject' => 'required',
        ]);
        $this->mailTemplateSvc->update($id, $request->except('_token', '_method', 'files'));
        return redirect(route('admin.mail-templates.index'));
    }

    public function show()
    {
        $nifties = $this->niftyAssistantRepo->getAll();
        $mail_templates = $this->mailTemplateRepo->getAll();
        return view('admin.mail-templates.compose', [
            'nifties'        => $nifties,
            'mail_templates' => $mail_templates,
        ]);
    }

    public function create()
    {
        return view('admin.mail-templates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->mailTemplateRepo->create($request->except('_token', 'files'));
        return back();
    }

    public function send(Request $request): RedirectResponse
    {
        $this->mailTemplateSvc->sendMail($request->except('_token', 'files'));
        flash('Email Sent Successfully!')->success();
        return redirect(route('admin.nifty_assistants.index'));
    }

    public function destroy($id): RedirectResponse
    {
        $this->mailTemplateRepo->delete($id);
        return back();
    }
}
