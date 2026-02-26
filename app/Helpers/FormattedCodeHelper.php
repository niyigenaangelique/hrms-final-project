<?php

namespace App\Helpers;

use App\Models\RecordHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class FormattedCodeHelper
{
    /**
     * Generates a formatted code with a prefix and zero-padded number.
     *
     * @param string $prefix The prefix to prepend to the code.
     * @param int $number The number to be zero-padded.
     * @param int $padding_length The total length of the zero-padded number.
     *
     * @return string A string in the format "PREFIX-00001".
     * @throws InvalidArgumentException If padding length is not a positive integer.
     */
    public static function generateFormattedCode(string $prefix, int $number, int $padding_length = 5): string
    {
        if ($padding_length <= 0) {
            throw new InvalidArgumentException("Padding length must be a positive integer.");
        }

        // Zero-pad the number to the specified length
        $zero_padded_number = str_pad((string)$number, $padding_length, '0', STR_PAD_LEFT);

        // Combine the prefix and the zero-padded number
        return sprintf('%s-%s', $prefix, $zero_padded_number);
    }

    /**
     * Generates the next formatted code for a model, ensuring uniqueness, based on the latest created_at, including soft-deleted records.
     *
     * @param string $modelClass The model class (e.g., RecordHistory::class).
     * @param string $prefix The prefix used in the formatted code (e.g., 'SGA').
     * @param int $padding_length The total length of the zero-padded number.
     *
     * @return string The next formatted code (e.g., "SGA-00001").
     */
    public static function getNextFormattedCode(string $modelClass, string $prefix, int $padding_length = 5): string
    {
        if (!class_exists($modelClass)) {
            throw new InvalidArgumentException("Invalid model class: {$modelClass}");
        }

        return DB::transaction(function () use ($modelClass, $prefix, $padding_length) {
            // Lock the latest record by created_at, including soft-deleted records
            $latestRecord = $modelClass::withTrashed()
                ->where('code', 'like', "{$prefix}-%")
                ->orderBy('created_at', 'desc')
                ->lockForUpdate()
                ->first();

            $lastCode = $latestRecord ? $latestRecord->code : null;
            Log::info("Last code for {$prefix}: {$lastCode}");

            // If no previous code exists, start with 1
            if (!$lastCode) {
                return self::generateFormattedCode($prefix, 1, $padding_length);
            }

            // Validate the code format
            if (!preg_match('/^([A-Z]+)-(\d+)$/i', $lastCode, $matches)) {
                Log::warning("Invalid code format: {$lastCode}. Starting fresh with {$prefix}-1.");
                return self::generateFormattedCode($prefix, 1, $padding_length);
            }

            $extracted_prefix = $matches[1];
            $current_number = (int)$matches[2];
            $next_number = $current_number + 1;

            // Ensure the prefix matches (case-insensitive)
            if (strtoupper($extracted_prefix) !== strtoupper($prefix)) {
                Log::warning("Prefix mismatch: expected {$prefix}, found {$extracted_prefix}. Using {$prefix}.");
            }

            return self::generateFormattedCode($prefix, $next_number, $padding_length);
        });
    }
}
