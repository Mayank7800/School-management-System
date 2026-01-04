<?php

namespace App\Http;
use App\Http\Middleware\EnsureUserIsAuthenticated;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     */
    protected $middleware = [
        // Add any global middleware here if needed
    ];

    /**
     * The application's route middleware groups.
     */
    protected $middlewareGroups = [
        'web' => [
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     */
    protected $routeMiddleware = [
        // Custom auth middleware
        'ensure.auth' => EnsureUserIsAuthenticated::class,
    ];

    // app/Console/Kernel.php

protected function schedule(Schedule $schedule)
{
    // Send fee reminders every day at 9 AM
    $schedule->command('whatsapp:send-fee-reminders')->dailyAt('09:00');
    
    // Or test every minute during development
    // $schedule->command('whatsapp:send-fee-reminders')->everyMinute();
}
}
