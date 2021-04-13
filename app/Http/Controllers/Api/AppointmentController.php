<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Controller;
use App\Services\AppointmentService;
use App\Services\FileService;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    private $appointmentSvc;
    private $fileSvc;

    /**
     * AppointmentController constructor.
     * @param AppointmentService $appointmentSvc
     * @param FileService $fileSvc
     */
    public function __construct(
        AppointmentService $appointmentSvc,
        FileService $fileSvc
    ) {
        $this->appointmentSvc = $appointmentSvc;
        $this->fileSvc = $fileSvc;
    }

    public function store(Request $request): bool
    {
        $request->validate([
            'task_ids' => 'required',
        ]);

        if (!$request->user()) {
            return false;
        }

        $data = $request->all();

        $data['user_id'] = $request->user()->id;

        $documents = [];

        if ($request->hasFile('appointment_documents')) {
            foreach ($request->file('appointment_documents') as $i => $appointment_doc) {
                $path = $this->fileSvc->uploadFile($appointment_doc, 'appointment_documents');
                $name = 'Appointment Document - '.($i + 1);
                $documents[] = [
                    'name' => $name,
                    'path' => $path,
                ];
            }
            unset($data['appointment_documents']);
        }

        $data['documents'] = $documents;

        return $this->appointmentSvc->storeAppointment($data);
    }
}
