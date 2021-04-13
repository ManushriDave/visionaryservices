<?php

namespace App\Services;

use App\Enums\MailType;
use App\Mail\NewMail;
use App\Mail\NiftyAssistantApproved;
use App\Mail\NiftyOnHold;
use App\Mail\NiftyRegistered;
use App\Mail\NiftyRejected;
use App\Repositories\MailTemplateRepository;
use App\Repositories\NiftyAssistantRepository;
use Hash;
use Illuminate\Support\Str;
use Mail;

class MailTemplateService
{
    private MailTemplateRepository $mailTemplateRepo;
    private NiftyAssistantRepository $niftyAssistantRepo;

    /**
     * MailTemplateService constructor.
     * @param MailTemplateRepository $mailTemplateRepo
     * @param NiftyAssistantRepository $niftyAssistantRepo
     */
    public function __construct(
        MailTemplateRepository $mailTemplateRepo,
        NiftyAssistantRepository $niftyAssistantRepo
    ) {
        $this->mailTemplateRepo = $mailTemplateRepo;
        $this->niftyAssistantRepo = $niftyAssistantRepo;
    }

    public function update($id, $data)
    {
        $this->mailTemplateRepo->get($id)->update($data);
    }

    public function newMail(array $data)
    {
        $nifties = $this->niftyAssistantRepo->getAll();
        if ($data['nifty_ids'][0] === '0') {
            foreach ($nifties as $nifty) {
                Mail::to($nifty->email)->send(new NewMail($data));
            }
        } else {
            foreach ($data['nifty_ids'] as $nifty_id) {
                $nifty = $nifties->firstWhere('id', $nifty_id);
                $data['content'] = Str::replaceArray('{{ nifty.name }}', [$nifty->first_name], $data['content']);
                Mail::to($nifty->email)->send(new NewMail($data));
            }
        }
    }

    public function sendMail(array $data)
    {
        $nifties = $this->niftyAssistantRepo->getAll();

        if ($data['email_template_id'] === '0') {
            $this->newMail($data);
            return;
        }

        $email_template = $this->mailTemplateRepo->get($data['email_template_id']);
        $template = (int) $email_template->mail_type;

        $mail_type = null;

        foreach ($data['nifty_ids'] as $nifty_id) {
            $nifty = $nifties->firstWhere('id', $nifty_id);

            if ($template == MailType::ACCEPTED) {
                $password = Str::random(10);
                $nifty->update([
                    'password' => Hash::make($password),
                ]);
                $mail_type = new NiftyAssistantApproved($nifty, $password);
            }

            if ($template == MailType::REGISTERED) {
                $mail_type = new NiftyRegistered($nifty);
            }

            if ($template == MailType::ON_HOLD) {
                $mail_type = new NiftyOnHold($data['reason']);
            }

            if ($template == MailType::REJECTED) {
                $mail_type = new NiftyRejected($data['reason']);
            }

            if ($template == MailType::CUSTOM) {
                $custom_template = mail_template_by_id($data['email_template_id']);
                $data['content'] = $custom_template->content;
                $data['subject'] = $custom_template->subject;
                $this->newMail($data);
                return;
            }

            Mail::to($nifty->email)->send($mail_type);
        }
    }
}
