<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('config_notification', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('value');
            $table->timestamps();
        });

        // Заполнение таблицы данными
        DB::table('config_notification')->insert(
            [
                ['key' => 'blocking_time', 'value' => '10'],
                ['key' => 'max_count_attempt_confirm', 'value' => '3'],
                ['key' => 'confirmation_time', 'value' => '5'],
            ],

        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_notification');
    }
};
