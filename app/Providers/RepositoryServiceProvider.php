<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository;
use App\Repositories\AssistantTypeRepository;
use App\Repositories\ChatRoomRepository;
use App\Repositories\CouponRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\EmirateRepository;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Interfaces\AssistantTypeRepositoryInterface;
use App\Repositories\Interfaces\ChatRoomRepositoryInterface;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Repositories\Interfaces\CurrencyRepositoryInterface;
use App\Repositories\Interfaces\EmirateRepositoryInterface;
use App\Repositories\Interfaces\NiftyAssistantRepositoryInterface;
use App\Repositories\Interfaces\NiftyHomeDataRepositoryInterface;
use App\Repositories\Interfaces\NiftyRankRepositoryInterface;
use App\Repositories\Interfaces\NiftyServiceRepositoryInterface;
use App\Repositories\Interfaces\PaymentRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\NiftyAssistantRepository;
use App\Repositories\NiftyHomeDataRepository;
use App\Repositories\NiftyRankRepository;
use App\Repositories\NiftyServiceRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AppointmentRepositoryInterface::class, AppointmentRepository::class);
        $this->app->bind(AssistantTypeRepositoryInterface::class, AssistantTypeRepository::class);
        $this->app->bind(ChatRoomRepositoryInterface::class, ChatRoomRepository::class);
        $this->app->bind(CouponRepositoryInterface::class, CouponRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
        $this->app->bind(EmirateRepositoryInterface::class, EmirateRepository::class);
        $this->app->bind(NiftyAssistantRepositoryInterface::class, NiftyAssistantRepository::class);
        $this->app->bind(NiftyHomeDataRepositoryInterface::class, NiftyHomeDataRepository::class);
        $this->app->bind(NiftyRankRepositoryInterface::class, NiftyRankRepository::class);
        $this->app->bind(NiftyServiceRepositoryInterface::class, NiftyServiceRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
