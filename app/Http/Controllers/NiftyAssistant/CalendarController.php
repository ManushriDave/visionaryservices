<?php

namespace App\Http\Controllers\NiftyAssistant;

use App\Contracts\Controller;
use App\Services\NiftyCalendarService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

/**
 * Class CalendarController
 * @package App\Http\Controllers\NiftyAssistant
 */
class CalendarController extends Controller
{
    private $niftyCalendarSvc;

    /**
     * CalendarController constructor.
     * @param $niftyCalendarSvc
     */
    public function __construct(NiftyCalendarService $niftyCalendarSvc)
    {
        $this->niftyCalendarSvc = $niftyCalendarSvc;
    }

    /**
     * @return Factory|View|Application
     */
    public function index()
    {
        $events = $this->niftyCalendarSvc->getAll();
        return view('niftyassistant.calendars.index', [
            'events' => $events,
        ]);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function store(Request $request): bool
    {
        $data = $request->all();
        $this->niftyCalendarSvc->storeEvent($data);
        return true;
    }

    public function destroy(Request $request): bool
    {
        $data = $request->all();
        $this->niftyCalendarSvc->destroyEvent($data);
        return true;
    }
}
