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
        Schema::create('send_phone_notification', function (Blueprint $table) {

            $table->uuid('id')->primary(); // Используем UUID как первичный ключ

            $table->uuid('uuid_list')
                ->constrained('phone_list', 'id');

            $table->string('driver')->comment('Драйвер отправки');
            $table->string('value')->unique()->comment('Номер телефона');
            $table->integer('code')->index()->comment('Код для подтверждения активации');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_phone_notification');
    }
};
