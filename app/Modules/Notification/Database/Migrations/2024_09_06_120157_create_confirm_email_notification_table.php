<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('confirm_email_notification', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Используем UUID как первичный ключ

            // $table->foreign('uuid_active') // Устанавливаем внешний ключ
            //     ->references('id') // Ссылаемся на столбец id другой таблицы
            //     ->on('send_email_notification'); // Указываем имя связанной таблицы

            $table->uuid('uuid_send') // Добавляем столбец uuid_active
                  ->constrained('send_email_notification', 'id');

            $table->string('code')->index()->comment('Введённый код пользователем');
            $table->boolean('confirm')->index()->comment('Статус подтрвеждения кода');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirm_email_notification');
    }
};
