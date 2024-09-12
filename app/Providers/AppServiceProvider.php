<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        //получение логики запросов в log
        if (!app()->environment('production')) {
            DB::listen(function ($query) {
                Log::info('-----------------Начало Запрос--------------------');
                Log::info('SQL: ' . $query->sql);
                Log::info('Bindings: ' . json_encode($query->bindings));
                Log::info('Time: ' . $query->time . ' ms');
                Log::info('Connection Name: ' . $query->connectionName);
                Log::info('Выполнено в: ' . now());
                Log::info('-----------------Конец Запрос--------------------');
            });
        }
    }
}
