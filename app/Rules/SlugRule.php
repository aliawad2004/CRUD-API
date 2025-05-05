<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SlugRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[a-z0-9-]+$/', $value)) {
            $fail('The :attribute field must only contain lowercase letters, numbers, and hyphens.');
        }
    }
}