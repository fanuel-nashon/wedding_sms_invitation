<?php

namespace App\Support;

class PhoneNumber
{
    /**
     * Strip everything but digits, producing the plain E.164 digit
     * string (no leading +) expected by the SMS gateway, e.g. "255738234345".
     */
    public static function normalize(?string $value): string
    {
        return preg_replace('/\D/', '', (string) $value);
    }
}
