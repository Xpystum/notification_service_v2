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
        Schema::create('confirm_email_notification', function (Blueprint $table) {
            $table->uuid('id')->primary(); // Используем UUID как первичный ключ

            $table->uuid('uuid_send') // Добавляем столбец uuid_active
                ->constrained('send_email_notification', 'id');

            $table->integer('code')->index()->comment('Введённый код пользователем');
            $table->boolean('confirm')->nullable()->index()->comment('Статус подтрвеждения кода');
            $table->timestamps();
        });

        //Создание функции для триггера
        DB::unprepared("
            CREATE OR REPLACE FUNCTION check_email_code_exists() -- устанавливаем функцию, или перезаписываем если существует
            RETURNS TRIGGER AS $$
            DECLARE
                code_exists BOOLEAN; -- декларируем переменную
            BEGIN
                -- Проверяем, существует ли код в таблице send_email_notification
                SELECT EXISTS (SELECT 1 FROM send_email_notification WHERE code = NEW.code) INTO code_exists;

                -- Устанавливаем значение confirm в зависимости от проверки
                NEW.confirm := code_exists;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ");

        // Создание триггера
        DB::unprepared("
            CREATE TRIGGER before_insert_confirm_email
            BEFORE INSERT ON confirm_email_notification
            FOR EACH ROW
            EXECUTE FUNCTION check_email_code_exists();
        ");

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('confirm_email_notification');

        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_confirm_email');
        DB::unprepared('DROP FUNCTION IF EXISTS check_email_code_exists');
    }
};
