<?php

namespace App\Providers;

use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('users', Auth::user());
        });

        View::composer('components.navbar', function ($view) {
            $userId = Auth::id(); // Ensure the user is authenticated
            $notificationCount = 0;

            if ($userId) {
                $notificationCount = DB::table('bookings')
                    ->where('user_id', $userId)
                    ->where('payment_status', 'Fully Paid')
                    ->where('booking_status', 'Approved')
                    ->count();
            }

            $view->with('notificationCount', $notificationCount);
        });

        View::composer('*', function ($view) {
            $notifications = Booking::where('payment_status', 'Fully Paid')
                ->where('booking_status', 'Approved')
                ->get();
            $view->with('notifications', $notifications);
        });

        View::share('bookings', Booking::all());
    }

}
