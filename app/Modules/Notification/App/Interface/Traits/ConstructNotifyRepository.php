<?php
namespace App\Modules\Notification\App\Interface\Traits;

use App\Modules\Notification\Repositories\NotificationRepository;

trait ConstructNotifyRepository
{
    public function __construct(

        public NotificationRepository $repository

    ) { }
}
