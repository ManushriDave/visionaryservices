<?php

namespace App\Services;

use App\Mail\ContactMail;
use App\Models\Support;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SupportService
{
    public function storeRequest(array $data): bool
    {
        try {
            $user = auth()->guard('niftyassistant')->user();
            $data['email'] = $user->email;
            Support::create($data);

            $data['name'] = $user->getName();
            foreach (config('mail.contact') as $contact) {
                Mail::to($contact)->send(new ContactMail($data));
            }
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
