<?php

namespace App\Services;

use App\Models\NiftyCalendar;
use App\Repositories\NiftyAssistantRepository;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class NiftyCalendarService
{
    private $niftyRepo;

    /**
     * NiftyCalendarService constructor.
     * @param $niftyRepo
     */
    public function __construct(NiftyAssistantRepository $niftyRepo)
    {
        $this->niftyRepo = $niftyRepo;
    }

    public function getAll(): Collection
    {
        $data = collect([]);

        $nifty = $this->niftyRepo->get(Auth::id());

        foreach ($nifty->availability as $availability) {
            $event_data = new Collection();
            $event_data->start_time = $availability->from_time;
            $event_data->end_time = $availability->to_time;
            $event_data->date = Carbon::parse('next '.$availability->day)->toDateString();
            $event_data->work = 'Availability Period';
            $event_data->class_name = 'bg-info';
            $data->push($event_data);
        }

        foreach ($nifty->calendars as $event) {
            $event_data = new Collection();
            $event_data->start_time = $event->start_time;
            $event_data->end_time = $event->end_time;
            $event_data->date = $event->date;
            $event_data->work = $event->work;
            $event_data->class_name = 'bg-primary';
            $data->push($event_data);
        }

        foreach ($this->appointments() as $appointment) {
            $event_data = new Collection();
            $event_data->start_time = $appointment->time;

            $duration_array = explode(':', $appointment->approx_duration);
            $minutes = (int) $duration_array[0] * 60;

            $event_data->end_time = Carbon::parse($appointment->time)->addMinutes($minutes)->toTimeString();
            $event_data->date = $appointment->date;
            $event_data->work = 'An appointment is scheduled with '.$appointment->user->name;
            $event_data->class_name = 'bg-danger';
            $data->push($event_data);
        }

        return $data;
    }

    private function appointments(): Collection
    {
        return $this->niftyRepo->getAcceptedTasks(Auth::id());
    }

    public function storeEvent(array $data)
    {
        $start = Carbon::parse($data['start_date']);
        $event['date'] = $start->toDateString();
        $event['start_time'] = $start->toTimeString();

        $event['end_time'] = Carbon::parse($data['end_date'])->toTimeString();

        $event['nifty_assistant_id'] = \Auth::id();

        $event['work'] = $data['work'];

        NiftyCalendar::create($event);
    }

    public function destroyEvent(array $data)
    {
        $start = Carbon::parse($data['start_date']);
        $event['date'] = $start->toDateString();
        $event['start_time'] = $start->toTimeString();

        $event['end_time'] = Carbon::parse($data['end_date'])->toTimeString();

        $event['nifty_assistant_id'] = \Auth::id();

        NiftyCalendar::where($event)->delete();
    }
}
