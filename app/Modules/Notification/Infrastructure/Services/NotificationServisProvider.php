<?php
namespace App\Modules\Notification\Infrastructure\Services;


use App\Modules\Notification\App\Commands\MakeNotificationMethodCommand;
use Illuminate\Support\ServiceProvider;

class NotificationServisProvider extends ServiceProvider
{
    public function register(): void
    {
        // $this->app->bind(NotificationService::class, function ($app) {
        //     return new NotificationService(
        //         serviceNotificationChannel: $app->make(NotificationChannelService::class)
        //     );
        // });
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
