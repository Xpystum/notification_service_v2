<?php
namespace App\Modules\Notification\Infrastructure\Services;


use App\Modules\Notification\Action\CheckNotificationAction;
use App\Modules\Notification\Action\CompleteNotificationAction;
use App\Modules\Notification\Action\CreateNotificationAction;
use App\Modules\Notification\Action\ExpiredNotificationAction;
use App\Modules\Notification\Action\GetMethodAction;
use App\Modules\Notification\Action\SelectSendNotificationAction;
use App\Modules\Notification\Action\SendNotificationAction;
use App\Modules\Notification\Action\UpdateNotificationAction;
use App\Modules\Notification\Drivers\Factory\NotificationDriverFactory;
use App\Modules\Notification\Enums\NotificationDriverEnum;
use App\Modules\Notification\Interface\NotificationDriverInterface;

class NotificationService
{

    #TODO Лучше не устанавливать драйвер непосредственно в сервес - в будущем могут быть проблемы - сделал для удобства.
    // private ?NotificationDriverInterface $driver = null;

    // public function driverNotNull() : bool
    // {
    //     return $this->driver ? true : false;
    // }

    // public function getDriver() : ?NotificationDriverInterface
    // {
    //     return $this->driver;
    // }

    // public function setDriver(NotificationDriverEnum|string $driver) : static
    // {
    //     $this->driver = $this->getDriverFactory($driver);
    //     return $this;
    // }

    // /**
    //  * Фабрика создание driver - создаёт драйвер (классом и настройками) - который мы прислали в параметре
    //  *
    //  * @param NotificationDriverEnum|string $driver
    //  *
    //  * @return NotificationDriverInterface
    //  */
    // public function getDriverFactory(NotificationDriverEnum|string $driver): NotificationDriverInterface
    // {
    //     return app(NotificationDriverFactory::class)->make($driver);
    // }

    // /**
    //  * Возвращает модель NotificationMethod по названию и драйверу
    //  * @return GetMethodAction
    //  */
    // public function getNotificationMethod() : GetMethodAction
    // {
    //     return app(GetMethodAction::class);
    // }

    // /**
    //  * Создат модель Notificaion в статусе panding по ссылке на NotificationMethod и User
    //  *
    //  * @return CreateNotificationAction
    //  */
    // public function createNotification() : CreateNotificationAction
    // {
    //     return app(CreateNotificationAction::class);
    // }

    // /**
    //  * Обновляет модель Notification (пока что только код)
    //  * @return UpdateNotificationAction
    //  */
    // public function updateNotification() : UpdateNotificationAction
    // {
    //     return app(UpdateNotificationAction::class);
    // }


    // // public function createNotification() :
    // // {

    // // }

    // /**
    //  * Запускает метод нотификации в зависимости от драйвера
    //  * @return SendNotificationAction
    //  */
    // public function sendNotification() : SendNotificationAction
    // {
    //     return new SendNotificationAction($this);
    // }

    // /**
    //  * Проверят подлинность отправленного кода пользователю
    //  * @return CheckNotificationAction
    //  */
    // public function checkNotification() : CheckNotificationAction
    // {
    //     return app(CheckNotificationAction::class);
    // }

    // /**
    //  * вызов метода send и его логики в зависимости от метода
    //  * @return [type]
    //  */
    // public function selectSendNotification() : SelectSendNotificationAction
    // {
    //     return new SelectSendNotificationAction($this);
    // }

}
