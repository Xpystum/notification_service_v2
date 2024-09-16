<?php
namespace App\Modules\Notification\App\Providers\Notification;

use Illuminate\Support\ServiceProvider;


class NotificationServiceProvider extends ServiceProvider
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

            $this->loadMigrationsFrom(dirname(__DIR__) . '/..' . '/..' . '/..' . 'Common' . '/Database' . '/Migrations');

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
