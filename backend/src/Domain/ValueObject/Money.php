<?php

declare(strict_types=1);

namespace QuimiCommerce\Domain\ValueObject;

final class Money implements \Stringable
{
    public function __construct(
        private readonly int $amount,
        private readonly Currency $currency,
    ) {
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function equals(self $other): bool
    {
        return $this->amount === $other->amount
            && $this->currency === $other->currency;
    }

    public function add(self $other): self
    {
        $this->assertSameCurrency($other);

        return new self(
            $this->amount + $other->amount,
            $this->currency,
        );
    }

    public function subtract(self $other): self
    {
        $this->assertSameCurrency($other);

        return new self(
            $this->amount - $other->amount,
            $this->currency,
        );
    }

    public function multiply(float $multiplier): self
    {
        return new self(
            (int) ($this->amount * $multiplier),
            $this->currency,
        );
    }

    public function format(): string
    {
        $value = $this->amount / 100;

        return $this->currency->getSymbol().number_format($value, $this->currency->getDecimalPlaces());
    }

    public function isZero(): bool
    {
        return 0 === $this->amount;
    }

    public function isPositive(): bool
    {
        return $this->amount > 0;
    }

    public function isNegative(): bool
    {
        return $this->amount < 0;
    }

    public function __toString(): string
    {
        return $this->format();
    }

    private function assertSameCurrency(self $other): void
    {
        if ($this->currency !== $other->currency) {
            throw new \DomainException(\sprintf('Cannot operate on different currencies: %s and %s', $this->currency->value, $other->currency->value));
        }
    }
}
