<?php

declare(strict_types=1);

namespace QuimiCommerce\Domain\Entity;

final class Category implements \Stringable
{
    public function __construct(
        private readonly string $id,
        private readonly string $name,
        private readonly string $slug,
        private readonly ?string $description = null,
        private readonly ?self $parentCategory = null,
        private readonly bool $isActive = true,
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

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getParentCategory(): ?self
    {
        return $this->parentCategory;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function hasChildren(): bool
    {
        return null === $this->parentCategory;
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
