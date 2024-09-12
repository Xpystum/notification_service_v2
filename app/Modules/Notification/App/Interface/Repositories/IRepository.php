<?php

namespace App\Modules\Notification\App\Interface\Repositories;

use Illuminate\Database\Eloquent\Model;

interface IRepository
{
    public function save($email);
    public function getById($uuid) : ?Model;
}
