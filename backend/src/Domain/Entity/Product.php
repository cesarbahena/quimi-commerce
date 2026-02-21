<?php

declare(strict_types=1);

namespace QuimiCommerce\Domain\Entity;

use QuimiCommerce\Domain\ValueObject\Money;

final class Product implements \Stringable
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $description,
        private readonly Money $price,
        private readonly string $sku,
        private readonly bool $isActive = true,
        private readonly int $stockQuantity = 0,
    ) {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): Money
    {
        return $this->price;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }

    public function isInStock(): bool
    {
        return $this->stockQuantity > 0;
    }

    public function equals(self $other): bool
    {
        return $this->id === $other->id;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
