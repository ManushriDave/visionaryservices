<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class WhatsAppChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toWhatsApp($notifiable);

        $to = $notifiable->routeNotificationFor('WhatsApp');
        $from = config('services.twilio.whatsapp_from');

        try {
            $twilio = new Client(config('services.twilio.sid'), config('services.twilio.token'));
        } catch (ConfigurationException $e) {
            Log::error($e->getMessage());
            return false;
        }

        try {
            return $twilio->messages->create('whatsapp:' . $to, [
                "from" => 'whatsapp:' . $from,
                "body" => $message->content
            ]);
        } catch (TwilioException $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
