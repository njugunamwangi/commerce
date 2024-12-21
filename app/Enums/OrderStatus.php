<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum OrderStatus: string implements HasLabel
{
    case New = 'new';
    case Processing = 'processing';
    case Completed = 'completed';

    public const DEFAULT = self::New;

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function getLabel(): ?string
    {
        return match($this) {
            self::New => 'New',
            self::Processing => 'Processing',
            self::Completed => 'Completed',
        };
    }
}
