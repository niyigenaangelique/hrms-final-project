<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class MacAddress implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Accepts colon-separated, hyphen-separated, or dot-separated MAC addresses
        $pattern = '/^([0-9A-Fa-f]{2}([-:])){5}[0-9A-Fa-f]{2}$|^[0-9A-Fa-f]{4}\.[0-9A-Fa-f]{4}\.[0-9A-Fa-f]{4}$/';

        if (!preg_match($pattern, $value)) {
            $fail('The :attribute must be a valid MAC address (e.g. 00:1A:2B:3C:4D:5E).');
        }
    }
}
