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
        DB::unprepared(
            "CREATE OR REPLACE FUNCTION check_email_code_exists() -- устанавливаем функцию, или перезаписываем если существует
            RETURNS TRIGGER AS $$
            DECLARE
                code_exists BOOLEAN; -- декларируем переменную
                emailList_uuid UUID;
            BEGIN
                -- Проверяем, существует ли код в таблице send_email_notification
                -- p.s надо учитывать время последнего кода если код и uuid будет одинаковый он все равно примит его не учитывая время
                SELECT EXISTS (SELECT 1 FROM send_email_notification WHERE code = NEW.code AND id = NEW.uuid_send) INTO code_exists;

                -- Устанавливаем значение confirm в зависимости от проверки
                NEW.confirm := code_exists;

                -- обновление статуса если true в таблице email/phone_list
                IF code_exists THEN

                    -- получаем uuid email_list
                    SELECT uuid_list
                    INTO emailList_uuid
                    FROM send_email_notification
                    WHERE code = NEW.code AND id = NEW.uuid_send
                    LIMIT 1;

                    UPDATE email_list
                    SET status = true
                    WHERE id = emailList_uuid;
                END IF;

                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;"
        );

        // Создание триггера
        DB::unprepared(
            "CREATE TRIGGER before_insert_confirm_email
            BEFORE INSERT ON confirm_email_notification
            FOR EACH ROW
            EXECUTE FUNCTION check_email_code_exists();"
        );

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
