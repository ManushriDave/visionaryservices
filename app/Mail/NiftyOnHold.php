<?php

namespace App\Mail;

use App\Enums\MailType;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class NiftyOnHold extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $reason;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($reason)
    {
        $this->reason = $reason;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = mail_template(MailType::ON_HOLD);
        $content = Str::of($data->content)->replace('{{ reason }}', $this->reason);
        return $this->html($content)->subject($data->subject);
    }
}
