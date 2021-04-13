<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            // Auth Routes
            Route::prefix('auth')
                ->middleware('web')
                ->namespace($this->namespace.'\\Auth')
                ->group(app_path('Routes/auth.php'));

            // API Routes
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace.'\\Api')
                ->group(app_path('Routes/api.php'));

            // Frontend Routes
            Route::middleware('web')
                ->namespace($this->namespace.'\\Frontend')
                ->group(app_path('Routes/frontend.php'));

            // Admin Routes
            Route::prefix('admin')
                ->middleware('web')
                ->namespace($this->namespace.'\\Admin')
                ->group(app_path('Routes/admin.php'));

            // Password Routes
            Route::middleware(['web', 'guest'])
                ->namespace($this->namespace.'\\Auth')
                ->group(app_path('Routes/password.php'));

            // Admin Routes
            Route::prefix('nifty-assistant')
                ->middleware('web')
                ->group(app_path('Routes/niftyassistant.php'));

            // Chat Routes
            Route::prefix('chat')
                ->middleware('web')
                ->namespace($this->namespace)
                ->group(app_path('Routes/chat.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }
}
