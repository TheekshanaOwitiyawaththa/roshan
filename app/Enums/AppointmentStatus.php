<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Cancelled = 'cancelled';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Pending',
            self::Confirmed => 'Confirmed',
            self::Cancelled => 'Cancelled',
            self::Completed => 'Completed',
        };
    }

    public function calendarColor(): string
    {
        return match ($this) {
            self::Pending => '#d97706',
            self::Confirmed => '#01261f',
            self::Cancelled => '#e11d48',
            self::Completed => '#059669',
        };
    }

    public function calendarBorderColor(): string
    {
        return match ($this) {
            self::Pending => '#b45309',
            self::Confirmed => '#001a15',
            self::Cancelled => '#be123c',
            self::Completed => '#047857',
        };
    }

    /**
     * @return array<string, string>
     */
    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $status) => [$status->value => $status->label()])
            ->all();
    }
}
