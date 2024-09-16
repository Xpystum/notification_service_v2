<?php

namespace App\Modules\Notification\Common\Helpers;
use Illuminate\Support\Str;

if (!function_exists('uuid')) {
    function uuid(string $path = '') : string
    {
        return (string) Str::uuid();
    }
}


if (!function_exists('code')) {
    function code() : int
    {
        return rand(100_000, 999_999);
    }
}

