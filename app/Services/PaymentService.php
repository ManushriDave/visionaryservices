<?php

namespace App\Services;

use App\Models\Payment;
use App\Repositories\AppointmentRepository;
use App\Repositories\PaymentRepository;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    private $paymentRepo;
    private $appointmentRepo;

    /**
     * PaymentService constructor.
     * @param AppointmentRepository $appointmentRepo
     * @param PaymentRepository $paymentRepo
     */
    public function __construct(
        AppointmentRepository $appointmentRepo,
        PaymentRepository $paymentRepo
    ) {
        $this->appointmentRepo = $appointmentRepo;
        $this->paymentRepo = $paymentRepo;
    }

    public function get($id)
    {
        return $this->paymentRepo->get($id);
    }

    public function getAll($limit = null): Collection
    {
        return $this->paymentRepo->getAll($limit);
    }

    public function store($array)
    {
        $appointment = $this->appointmentRepo->get($array['appointment_id']);

        $assistant_type = $appointment->assistant_type;

        $customer_cost_per_hour = $assistant_type->cost_per_hour;
        $nifty_cost_per_hour = $assistant_type->rank->cost_per_hour;

        $customer_total = $appointment->approx_duration * $customer_cost_per_hour;

        $nifty_commission = $appointment->approx_duration * $nifty_cost_per_hour;

        Payment::create([
            'payment_id'       => $array['payment_id'],
            'appointment_id'   => $appointment->id,
            'nifty_commission' => $nifty_commission,
            'total'            => $customer_total,
        ]);

        return true;
    }

    public function getTimeline(): array
    {
        $timeline = [];
        $payments = $this->getAll();
        foreach ($payments as $payment) {
            $string = 'Payment of INR '.$payment->total.' was initiated by '.$payment->appointment->user->name;
            array_push($timeline, [
                'created_at' => $payment->created_at,
                'string'     => $string,
                'link'       => route('admin.payments.show', $payment->id),
            ]);
        }
        return $timeline;
    }

    public function getTotalRevenue()
    {
        $payments = $this->getAll();
        $total = 0;
        foreach ($payments as $payment) {
            $total += $payment->total;
        }
        return $total;
    }

    public function getTotalNiftyCommission()
    {
        $payments = $this->getAll();
        $total = 0;
        foreach ($payments as $payment) {
            $total += $payment->nifty_commission;
        }
        return $total;
    }

    public function getMonthlySales($limit)
    {
        $payment_months = $this->getAll()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        $payments_count = [];

        foreach ($payment_months as $key => $payment_month) {
            $payments_count['month'][] = Carbon::create()->month($key)->monthName;
            $payments_data = 0;
            foreach ($payment_month as $data) {
                $payments_data += $data->total;
            }
            $payments_count['data'][] = $payments_data;
        }

        return $payments_count;
    }

    public function getMonthlyCosts(int $int)
    {
        $payment_months = $this->getAll()->groupBy(function ($date) {
            return Carbon::parse($date->created_at)->format('m'); // grouping by months
        });

        $payments_count = [];

        foreach ($payment_months as $key => $payment_month) {
            $payments_count['month'][] = Carbon::create()->month($key)->monthName;
            $payments_data = 0;
            foreach ($payment_month as $data) {
                if (!$data->appointment->nifty_service_id) {
                    continue;
                }
                $nifty_commission = $data->appointment->nifty_service->nifty_assistant->rank->commission;
                $payments_data += $data->total - ($nifty_commission * $data->total / 100);
            }
            $payments_count['data'][] = $payments_data;
        }

        return $payments_count;
    }
}
