<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;   // ✅ ADD THIS
use Illuminate\Support\Facades\Auth;   // ✅ ADD THIS
use App\Models\Notification;


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
        View::composer('components.admin-layout', function ($view) {
        $user = Auth::user();

        if (!$user || $user->role !== 'admin') {
            $view->with([
                'unreadNotificationsCount' => 0,
                'recentNotifications'      => collect(),
            ]);
            return;
        }

        $notifications = Notification::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $view->with([
            'unreadNotificationsCount' => $notifications->where('is_read', false)->count(),
            'recentNotifications'      => $notifications,
        ]);
    });

    }
}
