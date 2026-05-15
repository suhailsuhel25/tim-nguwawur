<?php

namespace App\Providers;

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
        \Illuminate\Support\Facades\View::composer('components.navbar', function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $unreadNotifications = \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())
                    ->where('is_read', false)
                    ->orderByDesc('created_at')
                    ->take(5)
                    ->get();
                
                $unreadCount = \App\Models\Notification::where('user_id', \Illuminate\Support\Facades\Auth::id())
                    ->where('is_read', false)
                    ->count();

                $view->with(compact('unreadNotifications', 'unreadCount'));
            }
        });
    }
}
