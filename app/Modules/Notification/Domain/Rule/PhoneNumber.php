<?php

namespace App\Modules\Notification\Domain\Rule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumber implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^(\+7|7|8)?(9\d{9})$/', $value)) {
            $fail('Неверный формат мобильного телефона. Он должен быть в формате +7XXXXXXXXXX или 7XXXXXXXXXX.');
        }

    }

    public function message()
    {
        return 'Неверный формат мобильного телефона. Он должен быть в формате +7XXXXXXXXXX или 7XXXXXXXXXX.';
    }
}
