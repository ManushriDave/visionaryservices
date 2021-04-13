<?php

namespace App\Repositories;

use App\Models\MailTemplate;

class MailTemplateRepository
{
    public function getAll()
    {
        return MailTemplate::all();
    }

    public function get($id)
    {
        return MailTemplate::find($id);
    }

    public function create($data)
    {
        return MailTemplate::create($data);
    }

    public function delete($id)
    {
        return $this->get($id)->delete();
    }
}
