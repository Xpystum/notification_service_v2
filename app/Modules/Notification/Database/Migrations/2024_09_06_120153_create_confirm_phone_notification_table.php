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
        Schema::create('confirm_phone_notification', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Используем UUID как первичный ключ

            $table->uuid('uuid_send') // Добавляем столбец uuid_active
                ->constrained('send_phone_notification', 'id');

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
        Schema::dropIfExists('confirm_phone_notification');
    }
};
