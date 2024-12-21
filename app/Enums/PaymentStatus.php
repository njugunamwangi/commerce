<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasLabel
{
    case Paid = 'paid';
    case Unpaid = 'unpaid';
    case Failed = 'failed';

    public const DEFAULT = self::Unpaid;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): ?string
    {
        return match($this) {
            self::Paid => 'Paid',
            self::Unpaid => 'Unpaid',
            self::Failed => 'Failed',
        };
    }
}
