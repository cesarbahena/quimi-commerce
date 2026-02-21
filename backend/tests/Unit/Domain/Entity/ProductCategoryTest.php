<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use QuimiCommerce\Domain\Entity\Category;
use QuimiCommerce\Domain\Entity\Product;
use QuimiCommerce\Domain\Entity\ProductCategory;
use QuimiCommerce\Domain\ValueObject\Currency;
use QuimiCommerce\Domain\ValueObject\Money;

class ProductCategoryTest extends TestCase
{
    public function testCreateProductCategory(): void
    {
        $product = new Product(
            id: 'prod_1',
            name: 'Test Product',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
        );

        $category = new Category(
            id: 'cat_1',
            name: 'Electronics',
            slug: 'electronics',
        );

        $productCategory = new ProductCategory(
            product: $product,
            category: $category,
        );

        self::assertSame($product, $productCategory->getProduct());
        self::assertSame($category, $productCategory->getCategory());
    }

    public function testProductCategoryEquality(): void
    {
        $product = new Product(
            id: 'prod_1',
            name: 'Test',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
        );

        $category = new Category(
            id: 'cat_1',
            name: 'Electronics',
            slug: 'electronics',
        );

        $pc1 = new ProductCategory($product, $category);
        $pc2 = new ProductCategory($product, $category);

        self::assertTrue($pc1->equals($pc2));
    }

    public function testProductCategoryNotEqual(): void
    {
        $product1 = new Product(
            id: 'prod_1',
            name: 'Product 1',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
        );

        $product2 = new Product(
            id: 'prod_2',
            name: 'Product 2',
            description: 'Desc',
            price: new Money(2000, Currency::USD),
            sku: 'SKU-002',
        );

        $category = new Category(
            id: 'cat_1',
            name: 'Electronics',
            slug: 'electronics',
        );

        $pc1 = new ProductCategory($product1, $category);
        $pc2 = new ProductCategory($product2, $category);

        self::assertFalse($pc1->equals($pc2));
    }
}
