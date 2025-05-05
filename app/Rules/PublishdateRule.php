<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PublishdateRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (strtotime($value) === false) {
            $fail('The :attribute must be a valid date.');
            return;
        }
        
        if (strtotime($value) <= time()) {
            $fail('The :attribute must be a future date.');
        }
    }
}
