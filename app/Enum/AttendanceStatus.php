<?php

namespace App\Enum;

enum AttendanceStatus: string
{
    case Entered = 'Entered';
    case Cancelled = 'Cancelled';
    case Rejected = 'Rejected';
    case Approved = 'Approved';
    case Posted = 'Posted';


    /**
     * Get the human-readable description for the role.
     */
    public function description(): string
    {
        return match ($this) {
            self::Entered => 'Entered - Attendance log has been entered but not posted yet.',
            self::Cancelled => 'Cancelled - Attendance log has been cancelled and will not be posted.',
            self::Rejected => 'Rejected - Attendance log has been rejected and requires changes before it can be posted again.',
            self::Approved => 'Approved - Attendance log has been approved and is ready for posting.',
            self::Posted => 'Posted - Attendance log has been posted to the payroll system.',

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
