<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class IpWithOptionalPort implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Regex to match IPv4 with optional port
        $pattern = '/^((25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}' .
            '(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(:(\d{1,5}))?$/';

        if (!preg_match($pattern, $value, $matches)) {
            $fail("The :attribute must be a valid IPv4 address with an optional port.");
            return;
        }

        // If port is present, validate its numeric range
        if (!empty($matches[4])) {
            $port = (int) $matches[4];
            if ($port < 1 || $port > 65535) {
                $fail("The port in :attribute must be between 1 and 65535.");
            }
        }
    }
}
