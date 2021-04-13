<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Controller;
use App\Enums\NiftyStatus;
use App\Services\AppointmentService;
use App\Services\AssistantTypeService;
use App\Services\EmirateService;
use App\Services\NiftyAssistantService;
use App\Services\PaymentService;
use App\Services\UserService;

class DashboardController extends Controller
{
    private $appointmentSvc;
    private $paymentSvc;
    private $userSvc;
    private $niftyAssistantSvc;
    private $assistantTypeSvc;
    private $emirateSvc;

    /**
     * DashboardController constructor.
     * @param AppointmentService $appointmentSvc
     * @param PaymentService $paymentSvc
     * @param UserService $userSvc
     * @param NiftyAssistantService $niftyAssistantSvc
     * @param AssistantTypeService $assistantTypeSvc
     * @param EmirateService $emirateSvc
     */
    public function __construct(
        AppointmentService $appointmentSvc,
        PaymentService $paymentSvc,
        UserService $userSvc,
        NiftyAssistantService $niftyAssistantSvc,
        AssistantTypeService $assistantTypeSvc,
        EmirateService $emirateSvc
    ) {
        $this->appointmentSvc = $appointmentSvc;
        $this->assistantTypeSvc = $assistantTypeSvc;
        $this->paymentSvc = $paymentSvc;
        $this->userSvc = $userSvc;
        $this->niftyAssistantSvc = $niftyAssistantSvc;
        $this->emirateSvc = $emirateSvc;
    }

    public function index()
    {
        $appointments = $this->appointmentSvc->getAll();

        $total_revenue = $this->paymentSvc->getTotalRevenue();
        $total_cost = $this->paymentSvc->getTotalNiftyCommission();
        $total_net = $total_revenue - $total_cost;

        $clients = $this->userSvc->getClients();
        $payments = $this->paymentSvc->getAll(5);
        $nifty_assistants = $this->niftyAssistantSvc->getAll();

        $pending_appointments = $this->appointmentSvc->getPending();
        $pending_assistants = $this->niftyAssistantSvc->getByStatus(NiftyStatus::PENDING);
        $pending_payouts = $this->appointmentSvc->getAssistantsPendingPayouts();

        $appointments_graph = $this->assistantTypeSvc->getAppointmentsGraph();
        $locations_graph = $this->emirateSvc->getAppointmentsLocationsGraph();
        $gender_graph = $this->niftyAssistantSvc->getGenderGraph();
        $nationality_graph = $this->niftyAssistantSvc->getNationalityGraph();
        $age_graph = $this->niftyAssistantSvc->getAgeGraph();
        $nifty_skills_graph = $this->niftyAssistantSvc->getNiftySkillsGraph();

        $top_nifty = $this->niftyAssistantSvc->topNifty();
        $top_nifties = $this->niftyAssistantSvc->getTopNifties(3);
        $bottom_nifties = $this->niftyAssistantSvc->getBottomNifties(3);

        $monthly_sales = $this->paymentSvc->getMonthlySales(12);
        $monthly_costs = $this->paymentSvc->getMonthlyCosts(12);

        $top_client = $this->userSvc->topClients(1, 1)->first();
        $top_clients = $this->userSvc->topClients(3);

        $timeline = $this->userSvc->timeline();

        return view('admin.dashboard.index', [
            'appointments'         => $appointments,
            'total_revenue'        => $total_revenue,
            'total_cost'           => $total_cost,
            'total_net'            => $total_net,
            'clients'              => $clients,
            'payments'             => $payments,
            'timeline'             => $timeline,
            'nifty_assistants'     => $nifty_assistants,
            'pending_appointments' => $pending_appointments,
            'pending_assistants'   => $pending_assistants,
            'pending_payouts'      => $pending_payouts,
            'appointments_graph'   => $appointments_graph,
            'locations_graph'      => $locations_graph,
            'gender_graph'         => $gender_graph,
            'nationality_graph'    => $nationality_graph,
            'age_graph'            => $age_graph,
            'nifty_skills_graph'   => $nifty_skills_graph,
            'top_nifty'            => $top_nifty,
            'top_nifties'          => $top_nifties,
            'bottom_nifties'       => $bottom_nifties,
            'top_client'           => $top_client,
            'top_clients'          => $top_clients,
            'monthly_sales'        => $monthly_sales,
            'monthly_costs'        => $monthly_costs,
        ]);
    }
}
