<?php

namespace App\Enum;

enum EmployeeCategory: string
{
    case PERMANENT = 'Permanent';
    case CASUAL = 'Casual';
    case EXEMPTED = 'Exempted';
    case SECOND_EMPLOYER = 'Second Employer';


    /**
     * Get the human-readable description for the role.
     */
    public function description(): string
    {
        return match ($this) {
            self::PERMANENT => 'A permanent employee is a regular employee who is employed full-time or part-time by the company.',
            self::CASUAL => 'A casual employee is an employee who is hired on a temporary or as-needed basis.',
            self::EXEMPTED => 'An exempted employee is an employee who is exempt from the minimum wage and overtime laws.',
            self::SECOND_EMPLOYER => 'A second employer is an employer who employs an employee who is already employed by another employer.',
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
