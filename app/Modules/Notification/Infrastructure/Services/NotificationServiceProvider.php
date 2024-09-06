<?php
namespace App\Modules\Notification\Infrastructure\Services;


use App\Modules\Notification\App\Commands\MakeNotificationMethodCommand;
use Illuminate\Support\ServiceProvider;


class NotificationServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Database' . '/Migrations');


            $this->commands([
                MakeNotificationMethodCommand::class,
            ]);
        }

    }
}
