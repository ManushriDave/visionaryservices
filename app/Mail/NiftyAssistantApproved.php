<?php

namespace App\Mail;

use App\Enums\MailType;
use App\Models\NiftyAssistant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NiftyAssistantApproved extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $nifty_assistant;
    protected $password;

    /**
     * Create a new message instance.
     *
     * @param NiftyAssistant $nifty_assistant
     * @param $password
     */
    public function __construct(NiftyAssistant $nifty_assistant, $password)
    {
        $this->nifty_assistant = $nifty_assistant;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = mail_template(MailType::ACCEPTED);
        $content = Str::of($data->content)->replace('{{ nifty.email }}', $this->nifty_assistant->email);
        $content = Str::of($content)->replace('{{ nifty.password }}', $this->password);
        return $this->html($content)
            ->attach(storage_path('app/other_documents/Nifty-Process.mp4'))
            ->subject($data->subject);
    }
}
