<?php

namespace Petecheyne\NovaNotifications;

use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Petecheyne\NovaNotifications\Http\Middleware\Authorize;
use Petecheyne\NovaNotifications\Nova\Notification;
use Petecheyne\NovaNotifications\Nova\NotificationTemplate;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-notifications');

        $this->loadMigrationsFrom(__DIR__.'/../databases/migrations');

        Nova::resourcesIn(__DIR__.'/../src/Nova');

        $this->app->booted(function () {
            $this->routes();
        });

        $this->app->booted(function () {
            $this->routes();

            Nova::resources([
                Notification::class,
                NotificationTemplate::class
            ]);
        });

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-notifications')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
