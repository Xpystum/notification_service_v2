<?php
namespace App\Modules\Notification\Tests\Feature;

use App\Modules\Notification\App\Actions\List\CreateEmailListAction;
use App\Modules\Notification\App\Actions\List\CreatePhoneListAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmEmailAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Confirm\CreateConfirmPhoneAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendEmailAction;
use App\Modules\Notification\App\Actions\SendAndConfirm\Send\CreateSendPhoneAction;
use App\Modules\Notification\App\Data\DTO\Service\CreateSendAction\CreateSendDTO;
use App\modules\Notification\App\Models\EmailList;
use App\modules\Notification\App\Models\PhoneList;
use App\modules\Notification\App\Models\SendEmail;
use App\modules\Notification\App\Models\SendPhone;
use App\Modules\Notification\Infrastructure\Repositories\Notification\Confirm\EmailConfirmRepository;
use App\Modules\Notification\Infrastructure\Repositories\Notification\Confirm\PhoneConfirmRepository;
use App\Modules\Notification\Infrastructure\Repositories\Notification\Send\SendEmailRepository;
use App\Modules\Notification\Infrastructure\Repositories\Notification\Send\SendPhoneRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

use function App\Modules\Notification\Helpers\code;

class NotificationTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_CreateEmailListToDatabase(): EmailList
    {
        $model = CreateEmailListAction::make('test@gmail.com');
        $this->assertDatabaseHas('email_list', [
            'id' => $model->id,
        ]);

        return $model;
    }

    public function test_CreatePhoneListToDatabase(): PhoneList
    {
        $model = CreatePhoneListAction::make('79200574635');

        $this->assertDatabaseHas('phone_list', [
            'id' => $model->id,
        ]);

        return $model;
    }

    public function test_createSendEmailTableToDatabase() : SendEmail
    {
        $modelList = $this->test_CreateEmailListToDatabase();

        $model = CreateSendEmailAction::make(CreateSendDTO::make(
            value : $modelList->value,
            driver : 'smtp',
            uuid : $modelList->id,
        ));

        $this->assertDatabaseHas('send_email_notification', [
            'id' => $model->id,
        ]);

        return $model;
    }

    public function test_createSendPhoneTableToDatabase(): SendPhone
    {
        $modelList = $this->test_CreatePhoneListToDatabase();

        $model = CreateSendPhoneAction::make(CreateSendDTO::make(
            value : $modelList->value,
            driver : 'aero',
            uuid : $modelList->id,
        ));


        $this->assertDatabaseHas('send_phone_notification', [
            'id' => $model->id,
        ]);

        return $model;
    }

    public function test_createConfirmEmailToDatabase(): void
    {

        $modelCreate = $this->test_createSendEmailTableToDatabase();
        $model = CreateConfirmEmailAction::make($modelCreate->code, $modelCreate->id);

        $this->assertDatabaseHas('confirm_email_notification', [
            'id' => $model->id,
        ]);
    }

    public function test_createConfirmPhoneToDatabase(): void
    {

        $modelCreate = $this->test_createSendEmailTableToDatabase();
        $model = CreateConfirmPhoneAction::make($modelCreate->code, $modelCreate->id);

        $this->assertDatabaseHas('confirm_phone_notification', [
            'id' => $model->id,
        ]);
    }

    //Repository Logic Test
    //P.S Дата в тестах через Carbon::now() работает не парвильно - указывать придётся вручную

    /**
    * Проверка отправки notification в определённый промежуток времени
    * @return void
    */
    public function test_repositoryEmailSend_confirmation_time()
    {
        $modelList = CreateEmailListAction::make('test@gmail.com');

        // Проверяем, что объект $modelList не равен null
        $this->assertNotNull($modelList);

        Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 0, 0));

        $model = CreateSendEmailAction::make(CreateSendDTO::make(
            value : $modelList->value,
            driver : 'smtp',
            uuid : $modelList->id,
        ));

        // Проверяем, что объект $model не равен null
        $this->assertNotNull($model);

        {
            $repository = new SendEmailRepository();
            $status = $repository->confirmation_time($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertTrue($status);
        }

        {
            Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 6, 0));

            $repository = new SendEmailRepository();
            $status = $repository->confirmation_time($model->id);

            //Проверяем что мы получили false (время подвеждения истекло)
            $this->assertFalse($status);
        }


        //Сбрасываем время
        $this->tearDown();
    }

    /**
    *
    * Проверка отправки notification в определённый промежуток времени
    *
    * @return void
    */
    public function test_repositoryPhoneSend_confirmation_time()
    {
        $modelList = CreatePhoneListAction::make('79200264437');

        // Проверяем, что объект $modelList не равен null
        $this->assertNotNull($modelList);

        Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 0, 0));

        $model = CreateSendPhoneAction::make(CreateSendDTO::make(
            value : $modelList->value,
            driver : 'aero',
            uuid : $modelList->id,
        ));

        // Проверяем, что объект $model не равен null
        $this->assertNotNull($model);

        {
            $repository = new SendPhoneRepository();
            $status = $repository->confirmation_time($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertTrue($status);
        }


        {
            Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 6, 0));

            $repository = new SendPhoneRepository();
            $status = $repository->confirmation_time($model->id);

            //Проверяем что мы получили false (время подвеждения истекло)
            $this->assertFalse($status);
        }


        //Сбрасываем время
        $this->tearDown();
    }

    /**
    * Проверяем на повторную отправку через время для email
    * @return void
    */
    public function test_not_block_send_email()
    {
        $modelList = CreateEmailListAction::make('test@gmail.com');

        // Проверяем, что объект $modelList не равен null
        $this->assertNotNull($modelList);

        Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 30, 0));

        $model = CreateSendEmailAction::make(CreateSendDTO::make(
            value : $modelList->value,
            driver : 'smtp',
            uuid : $modelList->id,
        ));

        // Проверяем, что объект $model не равен null
        $this->assertNotNull($model);

        {
            //если время через которое надо отправить прошло
            Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 41, 0));

            $repository = new SendEmailRepository();
            $status = $repository->not_block_send($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertTrue($status);
        }

        {
            //если время через которое надо отправить ещё не прошло
            Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 39, 0));

            $repository = new SendEmailRepository();
            $status = $repository->not_block_send($model->id);

            //Проверяем что мы получили false (время подвеждения истекло)
            $this->assertFalse($status);
        }

        //Сбрасываем время
        $this->tearDown();
    }

    /**
    * Проверяем на повторную отправку через время для phone
    * @return void
    */
    public function test_not_block_send_phone()
    {
        $modelList = CreatePhoneListAction::make('79200264437');

        // Проверяем, что объект $modelList не равен null
        $this->assertNotNull($modelList);

        Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 30, 0));

        $model = CreateSendPhoneAction::make(CreateSendDTO::make(
            value : $modelList->value,
            driver : 'smtp',
            uuid : $modelList->id,
        ));

        // Проверяем, что объект $model не равен null
        $this->assertNotNull($model);

        {
            //если время через которое надо отправить прошло
            Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 41, 0));

            $repository = new SendPhoneRepository();
            $status = $repository->not_block_send($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertTrue($status);
        }

        {
            //если время через которое надо отправить ещё не прошло
            Carbon::setTestNow(Carbon::create(2023, 10, 1, 12, 39, 0));

            $repository = new SendPhoneRepository();
            $status = $repository->not_block_send($model->id);

            //Проверяем что мы получили false (время подвеждения истекло)
            $this->assertFalse($status);
        }

        //Сбрасываем время
        $this->tearDown();
    }

    public function test_countConfirm_email()
    {
        $model = $this->test_createSendEmailTableToDatabase();
        // Проверяем, что объект $modelList не равен null
        $this->assertNotNull($model);

        $repository = new EmailConfirmRepository();

        {
            $status =  $repository->checkCountConfirm($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertTrue($status);
        }

        {
            //Создаём подтверждения три раза.
            $repository->save('123456', $model->id);
            $repository->save('123456', $model->id);
            $repository->save('123456', $model->id);

            $status =  $repository->checkCountConfirm($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertFalse($status);
        }

    }

    public function test_countConfirm_phone()
    {
        $model = $this->test_createSendPhoneTableToDatabase();
        // Проверяем, что объект $modelList не равен null
        $this->assertNotNull($model);

        $repository = new PhoneConfirmRepository();

        {
            $status =  $repository->checkCountConfirm($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertTrue($status);
        }

        {
            //Создаём подтверждения три раза.
            $repository->save('123456', $model->id);
            $repository->save('123456', $model->id);
            $repository->save('123456', $model->id);

            $status =  $repository->checkCountConfirm($model->id);

            //Проверяем что мы получили true (вр)
            $this->assertFalse($status);
        }

    }

    public function tearDown(): void
    {
        // Сбрасываем тестовое время
        Carbon::setTestNow();
        parent::tearDown();
    }
}
