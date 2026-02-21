<?php

declare(strict_types=1);

namespace QuimiCommerce\Domain\ValueObject;

enum Currency: string
{
    case USD = 'USD';
    case MXN = 'MXN';
    case EUR = 'EUR';

    public function getSymbol(): string
    {
        return match ($this) {
            self::USD => '$',
            self::MXN => '$',
            self::EUR => '€',
        };
    }

    public function getDecimalPlaces(): int
    {
        return match ($this) {
            self::USD, self::EUR => 2,
            self::MXN => 2,
        };
    }
}
