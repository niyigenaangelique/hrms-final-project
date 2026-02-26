<?php
declare(strict_types=1);

use CleverEggDigital\NumberToWords\NumberToWords;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

/**
 * Parses a number from a string with enhanced validation.
 * Removes all characters except digits, decimal point, and leading minus sign.
 * For strings with commas, treats commas as thousands separators and returns the full number.
 * Returns float or int if valid, or throws an exception if invalid.
 *
 * @param string $value Input string containing a number
 * @return float|int Parsed number
 * @throws InvalidArgumentException On invalid numeric format
 */
function parseNumber(string $value)
{
    // Allow digits, decimal point, and leading minus sign
    $cleaned = preg_replace('/[^0-9.-]/', '', $value);

    // Validate single minus sign at the start
    if (substr_count($cleaned, '-') > 1 || ($cleaned !== '' && $cleaned[0] !== '-' && strpos($cleaned, '-') !== false)) {
        throw new InvalidArgumentException("Invalid numeric format: invalid minus sign in '$value'");
    }

    // Validate single decimal point
    if (substr_count($cleaned, '.') > 1) {
        throw new InvalidArgumentException("Invalid numeric format: multiple decimal points in '$value'");
    }

    // Check for invalid cases like empty string, only minus, or only decimal
    if ($cleaned === '' || $cleaned === '-' || $cleaned === '.') {
        throw new InvalidArgumentException("Invalid numeric value: '$value'");
    }

    // Validate if the cleaned string is numeric
    if (!is_numeric($cleaned)) {
        throw new InvalidArgumentException("Invalid numeric value: '$value'");
    }

    return strpos($cleaned, '.') !== false ? (float)$cleaned : (int)$cleaned;
}

/**
 * Capitalizes each word in a string with multibyte support and normalizes spaces.
 *
 * @param string $value Input string
 * @param string $encoding Character encoding (default UTF-8)
 * @return string Properly capitalized string
 * @throws InvalidArgumentException On unsupported encoding
 */
function stringCapitalize(string $value, string $encoding = 'UTF-8'): string
{
    if (!in_array($encoding, mb_list_encodings(), true)) {
        throw new InvalidArgumentException("Unsupported encoding: '$encoding'");
    }

    $value = trim($value);
    if ($value === '') {
        return '';
    }

    // Normalize multiple spaces to a single space
    $value = preg_replace('/\s+/', ' ', $value);

    return mb_convert_case($value, MB_CASE_TITLE, $encoding);
}

/**
 * Converts a number into words using kwn/number-to-words with locale support.
 *
 * @param int|string $number Number to convert
 * @param string $locale Locale for conversion (default 'en')
 * @return string Number in words or error message
 */
function numberToWords($number, string $locale = 'en'): string
{
    if (!is_numeric($number)) {
        return 'Invalid number';
    }

    // Normalize input to string
    $numberStr = (string)$number;

    // If number is negative, strip minus for size check
    $compareStr = ltrim($numberStr, '-+');

    // Prevent overly large values
    if (bccomp($compareStr, (string)PHP_INT_MAX, 0) === 1) {
        return 'Number too large for conversion';
    }

    try {
        $numberToWords = new NumberToWords();
        return $numberToWords->toWords((int)$number, $locale);
    } catch (\Throwable $e) {
        \Log::error('Number to words conversion error: ' . $e->getMessage(), ['number' => $number, 'locale' => $locale]);
        return 'Error converting number: ' . $e->getMessage();
    }
}

/**
 * Converts a number into words with localization support using NumberFormatter.
 *
 * @param int|float|string $number Number to convert
 * @param string $locale Locale for conversion (default 'en')
 * @return string Number in words or error message
 */
function localizedNumberToWords($number, string $locale = 'en'): string
{
    if (!is_numeric($number)) {
        return 'Invalid number';
    }

    // Convert to string and normalize
    $numberStr = (string)$number;
    $numberStr = preg_replace('/^\+/', '', $numberStr);

    // Validate number size
    if (strlen(preg_replace('/[^0-9]/', '', $numberStr)) > 15) {
        return 'Number too large for accurate conversion';
    }

    try {
        $formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);

        // Split into integer and decimal parts
        $parts = explode('.', $numberStr, 2);
        $intPart = $parts[0];
        $decimalPart = $parts[1] ?? '';

        // Handle negative numbers
        $isNegative = strpos($intPart, '-') === 0;
        if ($isNegative) {
            $intPart = substr($intPart, 1);
            $words = 'minus ' . $formatter->format((int)$intPart);
        } else {
            $words = $formatter->format((int)$intPart);
        }

        // Handle decimal part
        if ($decimalPart !== '') {
            $words .= ' point';
            foreach (str_split($decimalPart) as $digit) {
                $words .= ' ' . $formatter->format((int)$digit);
            }
        }

        return $words;
    } catch (\ValueError $e) {
        \Log::error('Localized number to words conversion error: ' . $e->getMessage(), ['number' => $number, 'locale' => $locale]);
        return 'Conversion error: Invalid locale';
    } catch (\Exception $e) {
        \Log::error('Localized number to words conversion error: ' . $e->getMessage(), ['number' => $number, 'locale' => $locale]);
        return 'Conversion error: ' . $e->getMessage();
    }
}

/**
 * Calculate payslip details from net salary using EstimateGrossFromNet stored procedure.
 *
 * @param float|int|string $netSalary Net salary amount
 * @param string $employmentType Employment type (Permanent, Casual, Exempted, Second Employer)
 * @param bool $usePercentage Whether to use percentage for transport
 * @param float $transportPercentage Transport allowance percentage
 * @param float $transportFixed Fixed transport amount
 * @param int $timeout DB operation timeout in seconds
 * @return array Calculated payslip components
 * @throws InvalidArgumentException On invalid input
 * @throws RuntimeException On calculation failure
 */
function getPayslipDetails(
    $netSalary,
    string $employmentType = 'Permanent',
    bool $usePercentage = true,
    float $transportPercentage = 0.00,
    float $transportFixed = 0.00,
    int $timeout = 5
): array
{
    // Validate net salary
    if (!is_numeric($netSalary) || $netSalary < 0) {
        throw new InvalidArgumentException('Net salary must be a non-negative number.');
    }
    $netSalary = (float)$netSalary;

    // Validate employment type
    $validEmploymentTypes = ['Permanent', 'Casual', 'Exempted', 'Second Employer'];
    if (!in_array($employmentType, $validEmploymentTypes, true)) {
        throw new InvalidArgumentException(
            'Invalid employment type. Must be one of: ' . implode(', ', $validEmploymentTypes)
        );
    }

    // Validate transport values
    if ($transportPercentage < 0 || $transportPercentage > 100) {
        throw new InvalidArgumentException('Transport percentage must be between 0 and 100.');
    }
    if ($transportFixed < 0) {
        throw new InvalidArgumentException('Fixed transport amount cannot be negative.');
    }

    // Validate timeout
    if ($timeout < 1 || $timeout > 60) {
        throw new InvalidArgumentException('Timeout must be between 1 and 60 seconds.');
    }

    try {
        // Start a transaction
        DB::beginTransaction();

        // Set timeout for the operation
        DB::statement("SET SESSION max_execution_time = ?", [$timeout * 1000]);

        DB::select(
            'CALL EstimateGrossFromNet(?, ?, ?, ?, ?, @out_gross, @out_paye, @out_pension, @out_maternity, @out_cbhi, @out_net)',
            [
                $netSalary,
                $usePercentage ? 1 : 0,
                $transportPercentage,
                $transportFixed,
                $employmentType
            ]
        );

        $result = DB::selectOne(
            'SELECT
                @out_gross as gross_salary,
                @out_paye as paye,
                @out_pension as pension,
                @out_maternity as maternity,
                @out_cbhi as cbhi,
                @out_net as net_salary'
        );

        if (!is_numeric($result->gross_salary) || $result->gross_salary < 0) {
            throw new RuntimeException('Invalid gross salary calculated: ' . $result->gross_salary);
        }

        // Commit the transaction
        DB::commit();

        return [
            'gross_salary' => round((float)$result->gross_salary, 2),
            'paye' => round((float)$result->paye, 2),
            'pension' => round((float)$result->pension, 2),
            'maternity' => round((float)$result->maternity, 2),
            'cbhi' => round((float)$result->cbhi, 2),
            'net_salary' => round((float)$result->net_salary, 2),
            'calculation_date' => now()->toDateTimeString(),
        ];
    } catch (QueryException $e) {
        DB::rollBack();
        \Log::error('Payslip calculation database error: ' . $e->getMessage(), [
            'net_salary' => $netSalary,
            'employment_type' => $employmentType
        ]);
        throw new RuntimeException('Database error during payslip calculation: ' . $e->getMessage());
    } catch (Exception $e) {
        DB::rollBack();
        \Log::error('Payslip calculation error: ' . $e->getMessage(), [
            'net_salary' => $netSalary,
            'employment_type' => $employmentType
        ]);
        throw new RuntimeException('Failed to calculate payslip details: ' . $e->getMessage());
    }
}
