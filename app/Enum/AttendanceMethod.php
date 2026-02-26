<?php

namespace App\Enum;

enum AttendanceMethod: string
{


    case Face_Recognition = 'Face Recognition';
    case Finger_Prints = 'Finger Prints';
    case Manuel_Input = 'Manuel Input';
    case Bulk_Upload = 'Bulk Upload';

    /**
     * Get the human-readable description for the role.
     */
    public function description(): string
    {
        return match ($this) {
            self::Face_Recognition => 'Face Recognition (using a camera to identify the user\'s face)',
            self::Finger_Prints => 'Finger Prints (using a fingerprint reader to identify the user)',
            self::Manuel_Input => 'Manuel Input (entering the user\'s attendance manually)',
            self::Bulk_Upload => 'Bulk Upload (uploading attendance data from a CSV file)',

        };
    }



    /**
     * Get all enum values as an array.
     *
     * @return array<string>
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
    /**
     * Get all the enum values as an array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all the enum names as an array
     */
    public static function getNames(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function caseWithDescriptions(): array
    {
        return array_map(fn($case) => [
            'value' => $case->value,
            'name' => $case->name,
            'description' => $case->description(),
        ], self::cases());
    }

    /**
     * Returns an associative array suitable for <select> dropdowns.
     *
     * @return array<string>
     */
    public static function forSelect(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($status) => [$status->value => $status->name])
            ->all();
    }
    public static function detailedList(): array
    {
        return array_map(fn($case) => [
            'key' => $case->value,
            'name' => $case->name,
            'label' => ucwords(str_replace('_', ' ', preg_replace('/(?<!^)[A-Z]/', ' $0', $case->value))),
            'description' => $case->description(),
        ], self::cases());
    }

}
