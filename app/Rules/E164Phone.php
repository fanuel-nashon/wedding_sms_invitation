<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class E164Phone implements ValidationRule
{
    /**
     * Validates an E.164-style number stored as digits only (no leading +),
     * e.g. "255738234345" — country code first, no leading 0, 9 to 15 digits.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^[1-9]\d{8,14}$/', (string) $value)) {
            $fail('The :attribute must be a valid international phone number in E.164 format (e.g. 255738234345) — digits only, starting with the country code, no leading 0 or +.');
        }
    }
}
