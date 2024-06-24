<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
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
        Blade::directive('taskmaster', function ($expression) {
            return "<?php if (auth()->user()->isTaskmaster(Route::current()->parameters()['assignment'])): ?>";
        });

        Blade::directive('endtaskmaster', function ($expression) {
            return "<?php endif; ?>";
        });

        Blade::directive('assignee', function ($expression) {
            return "<?php if (auth()->user()->isAssignee(Route::current()->parameters()['assignment'])): ?>";
        });

        Blade::directive('endassignee', function ($expression) {
            return "<?php endif; ?>";
        });
    }
}
