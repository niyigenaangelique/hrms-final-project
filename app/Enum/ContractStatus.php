<?php

namespace App\Enum;

enum ContractStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case EXPIRED = 'expired';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case TERMINATED = 'terminated';


    /**
     * Get the human-readable description for the role.
     */
    public function description(): string
    {
        return match ($this) {
            self::DRAFT => 'Contract is in draft status.',
            self::PENDING => 'Contract is pending approval.',
            self::APPROVED => 'Contract is approved.',
            self::ACTIVE => 'Contract is active.',
            self::INACTIVE => 'Contract is inactive.',
            self::EXPIRED => 'Contract is expired.',
            self::REJECTED => 'Contract is rejected.',
            self::CANCELLED => 'Contract is cancelled.',
            self::TERMINATED => 'Contract is terminated.',


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
