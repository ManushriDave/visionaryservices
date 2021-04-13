<?php

namespace App\Services;

use App\Enums\Updater;
use App\Mail\ContactMail;
use App\Models\Billing;
use App\Models\NiftyWallet;
use App\Models\User;
use App\Repositories\UserRepository;
use Auth;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Mail;

class UserService
{
    private $userRepo;
    /**
     * @var PaymentService
     */
    private $paymentSvc;
    /**
     * @var AppointmentService
     */
    private $appointmentService;
    /**
     * @var NiftyAssistantService
     */
    private $niftyAssistantSvc;

    /**
     * UserService constructor.
     * @param UserRepository $userRepo
     * @param AppointmentService $appointmentService
     * @param PaymentService $paymentSvc
     * @param NiftyAssistantService $niftyAssistantSvc
     */
    public function __construct(
        UserRepository $userRepo,
        AppointmentService $appointmentService,
        PaymentService $paymentSvc,
        NiftyAssistantService $niftyAssistantSvc
    ) {
        $this->appointmentService = $appointmentService;
        $this->paymentSvc = $paymentSvc;
        $this->userRepo = $userRepo;
        $this->niftyAssistantSvc = $niftyAssistantSvc;
    }

    public function getTimeline(): array
    {
        $timeline = [];
        $clients = $this->getClients();
        foreach ($clients as $user) {
            $string = 'New Client Joined : '.$user->name;
            array_push($timeline, [
                'created_at' => $user->created_at,
                'string'     => $string,
                'link'       => route('admin.users.show', $user->id),
            ]);
        }
        return $timeline;
    }

    public function timeline()
    {
        $appointments = $this->appointmentService->getTimeline();
        $clients = $this->getTimeline();
        $nifty_assistants = $this->niftyAssistantSvc->getTimeline();
        $earnings = $this->paymentSvc->getTimeline();

        $timeline = [];

        if (count($appointments) > 0 || count($clients) > 0 || count($nifty_assistants) > 0 || count($earnings) > 0) {
            $timeline = array_merge($appointments, $earnings, $clients, $nifty_assistants);

            foreach ($timeline as $key => $part) {
                $sort[$key] = strtotime($part['created_at']);
            }
            array_multisort($sort, SORT_DESC, $timeline);
        }
        return $timeline;
    }

    public function getClients()
    {
        return $this->userRepo->getClients();
    }

    public function get($id): User
    {
        return $this->userRepo->get($id);
    }

    public function getPendingBookings($user_id)
    {
        return $this->userRepo->getPendingBookings($user_id);
    }

    public function getOnGoingTasks(int $user_id)
    {
        return $this->userRepo->getOnGoingTasks($user_id);
    }

    public function getAllBookings(int $user_id)
    {
        return $this->userRepo->getAllBookings($user_id);
    }

    public function getPendingPayment(int $user_id)
    {
        $ongoing_bookings = $this->getOnGoingTasks($user_id);
        $pending_bookings = $this->getPendingBookings($user_id);

        $total = 0;

        foreach ($ongoing_bookings as $booking) {
            $total += $booking->total / 2;
        }

        foreach ($pending_bookings as $booking) {
            $total += $booking->total / 2;
        }

        return round($total, 2);
    }

    public function getPayments(int $user_id)
    {
        return $this->userRepo->getPayments($user_id);
    }

    public function getAdmins()
    {
        return $this->userRepo->getAdmins();
    }

    public function update(array $data): bool
    {
        $user = $this->userRepo->get($data['user_id']);
        if (array_key_exists(Updater::updateProfilePassword, $data)) {
            if (Hash::check($data['password'], $user->password)) {
                $user->password = Hash::make($data['new_password']);
                $user->save();
            } else {
                return false;
            }
        }

        if (array_key_exists(Updater::updateProfileBilling, $data)) {
            unset($data[Updater::updateProfileBilling]);
            try {
                Billing::updateOrCreate($data);
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return false;
            }
        }

        if (array_key_exists(Updater::updateProfileBasic, $data)) {
            unset($data[Updater::updateProfileBasic]);
            try {
                $user->update($data);
            } catch (QueryException $e) {
                Log::error($e->getMessage());
                return false;
            }
        }
        return true;
    }

    public function store($data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function register(array $data): bool
    {
        try {
            $user = $this->store($data);
            NiftyWallet::create([
                'user_id' => $user->id,
            ]);
            event(new Registered($user));

            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }

    public function topClient(): User
    {
        $highest_count = 0;
        $user = $this->userRepo->get(1);
        foreach ($this->getClients() as $client) {
            $appointments = $client->appointments->count();
            if ($appointments > $highest_count) {
                $highest_count = $appointments;
                $user = $client;
            }
        }
        return $user;
    }

    public function topClients($limit, $months = null): Collection
    {
        $counts = [];
        $users = [];

        foreach ($this->getClients() as $client) {
            $appointments = $client->appointments;
            if ($months) {
                $appointments->where('created_at', '=', Carbon::now()->subMonths($months)->toDateTimeString());
            }
            $counts[] = $client->appointments->count();
            $users[] = $client;
        }

        $top_clients = collect([]);

        if (count($counts) > 1) {
            for ($i = 1; $i <= $limit; $i++) {
                $maximum_count = max($counts);
                $maximum_count_key = array_search($maximum_count, $counts, true);

                $top_clients->push($users[$maximum_count_key]);

                unset($counts[$maximum_count_key]);
                unset($users[$maximum_count_key]);
            }
        }

        return $top_clients;
    }

    public function contact(array $data): bool
    {
        $emails = config('mail.contact');
        foreach ($emails as $email) {
            if ($email) {
                Mail::to($email)->send(new ContactMail($data));
            }
        }
        return true;
    }
}
