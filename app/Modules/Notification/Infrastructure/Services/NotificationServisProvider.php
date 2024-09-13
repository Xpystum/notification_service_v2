<?php
namespace App\Modules\Notification\Infrastructure\Services;


use App\Modules\Notification\App\Commands\MakeNotificationMethodCommand;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use App\modules\Notification\App\Models\ConfigNotification;

class NotificationServisProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            app_path('Modules\Notification\Config\notification.php'), 'notification'
        );
    }

    public function boot(): void
    {

        if($this->app->runningInConsole()){

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/Database' . '/Migrations');


            $this->commands([
                MakeNotificationMethodCommand::class,
            ]);
        }

        $this->loadNotificationConfigToDatabase();

    }

    /**
    * Записываем в config значение из базы данных и кешируем эти значение. P.S В Laravel Octane должно вызваться 1 раз при инициализации приложения
    * @return void
    */
    private function loadNotificationConfigToDatabase()
    {
        // Проверяем, есть ли кеш, чтобы избежать излишних запросов к базе данных
        // $configCacheKey = 'config_values_notification';

        // // Если кеш существует, берем его, иначе получаем значения из базы и сохраняем в кеш
        // $configValues = cache()->remember($configCacheKey, 86400, function () {
        //     return ConfigNotification::all();
        // });


        // foreach ($configValues as $configValue) {
        //     Config::set('notification.' . $configValue->key, $configValue->value);
        // }
    }
}
