<?php

namespace App\Mail;

use App\Enums\MailType;
use App\Models\NiftyAssistant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NiftyRegistered extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * @var string
     */
    public $nifty;

    /**
     * Create a new message instance.
     *
     * @param NiftyAssistant $nifty
     */
    public function __construct(NiftyAssistant $nifty)
    {
        $this->nifty = $nifty;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = mail_template(MailType::REGISTERED);
        $content = Str::of($data->content)->replace('{{ nifty.first_name }}', $this->nifty->first_name);
        return $this->html($content)
                    ->subject($data->subject);
    }
}
