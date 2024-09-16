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
        Schema::create('email_list', function (Blueprint $table) {

            $table->uuid('id')->primary(); // Используем UUID как первичный ключ
            $table->string('value')->unique()->comment('Почта');
            $table->boolean('status')->default(false)->comment('Статус активации');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_list');
    }
};
