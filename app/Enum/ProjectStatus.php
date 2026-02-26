<?php

namespace App\Enum;

enum ProjectStatus: string
{

    case NotStarted = 'not started';
    case InProgress = 'in progress';
    case InPlanning = 'in planning';
    case OnHold = 'on hold';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case Archived = 'archived';

    /**
     * Get the human-readable description for the role.
     */
    public function description(): string
    {
        return match ($this) {
            self::NotStarted => 'This project has not been started yet.',
            self::InPlanning => 'This project is currently in the planning phase.',
            self::InProgress => 'This project is currently in progress.',
            self::OnHold => 'This project is currently on hold.',
            self::Completed => 'This project has been completed.',
            self::Cancelled => 'This project has been cancelled.',
            self::Archived => 'This project has been archived.',
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
