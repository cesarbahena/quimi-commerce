<?php

declare(strict_types=1);

namespace QuimiCommerce\Domain\Entity;

final class ProductCategory
{
    public function __construct(
        private readonly Product $product,
        private readonly Category $category,
    ) {
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function equals(self $other): bool
    {
        return $this->product->equals($other->product)
            && $this->category->equals($other->category);
    }
}
