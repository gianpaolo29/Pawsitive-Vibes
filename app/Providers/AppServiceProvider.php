<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;
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
        Password::defaults(fn () => Password::min(8)
            ->letters()
            ->mixedCase()
            ->numbers()
            ->symbols()
        );

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
