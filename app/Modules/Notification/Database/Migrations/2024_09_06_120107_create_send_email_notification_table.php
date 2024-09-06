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
        Schema::create('send_email_notification', function (Blueprint $table) {

            $table->uuid('id')->primary(); // Используем UUID как первичный ключ
            $table->string('phone')->unique()->comment('Почта');
            $table->string('code')->index()->comment('Код для подтверждения активации');
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_email_notification');
    }
};
