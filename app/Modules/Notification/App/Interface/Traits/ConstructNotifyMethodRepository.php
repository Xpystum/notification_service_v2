<?php
namespace App\Modules\Notification\App\Interface\Traits;

use App\Modules\Notification\Repositories\NotificationMethodRepository;

trait ConstructNotifyMethodRepository
{
    public function __construct(

        public NotificationMethodRepository $repository

    ) { }
}
