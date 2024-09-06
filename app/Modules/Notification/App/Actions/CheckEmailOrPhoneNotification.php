<?php

namespace App\Modules\Notification\App\Action;

class CheckEmailOrPhoneNotification
{

    public function make(string $data)
    {
        return (new self())->run($data);
    }

    public function run()
    {
        
    }
}
