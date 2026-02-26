<?php

namespace App\Enum;

enum ApprovalStatus: string
{


    case NotApplicable = 'not applicable';
    case Initiated = 'initiated';
    case Pending = 'pending';
    case UnderReview = 'under review';
    case Approved = 'approved';
    case Rejected = 'rejected';
    case Cancelled = 'cancelled';
    case Closed = 'closed';



    /**
     * Get the human-readable description.
     */
    public function description(): string
    {
        return match ($this) {
            self::NotApplicable => 'This request does not require approval.',
            self::Initiated => 'This request has been initiated, but has not yet been sent to a manager for approval.',
            self::Pending => 'This request has been sent to a manager for approval, but has not yet been approved or rejected.',
            self::UnderReview => 'This request is currently being reviewed by a manager.',
            self::Approved => 'This request has been approved by a manager.',
            self::Rejected => 'This request has been rejected by a manager.',
            self::Cancelled => 'This request has been cancelled and is no longer being processed.',
            self::Closed => 'This request has been resolved and is no longer active.',
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
