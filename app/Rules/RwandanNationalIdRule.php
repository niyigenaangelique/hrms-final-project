<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class RwandanNationalIdRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param Closure(string, ?string=): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Check if the value is numeric and exactly 16 digits
        if (!is_numeric($value) || strlen((string)$value) !== 16) {
            $fail('The :attribute must be a 16-digit numeric Rwandan National ID.');
            return;
        }

        // Regular expression to match the pattern:
        // - 1st digit: 1 or 2
        // - Next 4 digits: Year of birth (any 4 digits, validated separately)
        // - 6th digit: 7 or 8
        // - Next 7 digits: Any 0-9
        // - 14th digit: Any 0-9
        // - Last 2 digits: Any 0-9
        if (!preg_match('/^[1-2][0-9]{4}[7-8][0-9]{7}[0-9]{1}[0-9]{2}$/', $value)) {
            $fail('The :attribute does not match the Rwandan National ID format.');
            return;
        }

        // Validate year of birth (digits 2-5)
        $year = (int)substr($value, 1, 4);
        $currentYear = (int)date('Y');
        if ($year < 1900 || $year > $currentYear) {
            $fail('The :attribute contains an invalid year of birth.');
        }
    }
}
