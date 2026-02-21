<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use QuimiCommerce\Domain\Entity\Product;
use QuimiCommerce\Domain\ValueObject\Currency;
use QuimiCommerce\Domain\ValueObject\Money;

class ProductTest extends TestCase
{
    public function testCreateProduct(): void
    {
        $product = new Product(
            id: 'prod_123',
            name: 'Test Product',
            description: 'A test product',
            price: new Money(1999, Currency::USD),
            sku: 'TEST-SKU-001',
        );

        self::assertSame('prod_123', $product->getId());
        self::assertSame('Test Product', $product->getName());
        self::assertSame('A test product', $product->getDescription());
        self::assertEquals(new Money(1999, Currency::USD), $product->getPrice());
        self::assertSame('TEST-SKU-001', $product->getSku());
    }

    public function testProductEquality(): void
    {
        $product1 = new Product(
            id: 'prod_123',
            name: 'Product A',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
        );

        $product2 = new Product(
            id: 'prod_123',
            name: 'Product B',
            description: 'Different desc',
            price: new Money(2000, Currency::USD),
            sku: 'SKU-002',
        );

        self::assertTrue($product1->equals($product2));
    }

    public function testProductNotEqualWithDifferentId(): void
    {
        $product1 = new Product(
            id: 'prod_123',
            name: 'Product',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
        );

        $product2 = new Product(
            id: 'prod_456',
            name: 'Product',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
        );

        self::assertFalse($product1->equals($product2));
    }

    public function testIsActive(): void
    {
        $activeProduct = new Product(
            id: 'prod_1',
            name: 'Active',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
            isActive: true,
        );

        $inactiveProduct = new Product(
            id: 'prod_2',
            name: 'Inactive',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-002',
            isActive: false,
        );

        self::assertTrue($activeProduct->isActive());
        self::assertFalse($inactiveProduct->isActive());
    }

    public function testDefaultIsActive(): void
    {
        $product = new Product(
            id: 'prod_1',
            name: 'Product',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
        );

        self::assertTrue($product->isActive());
    }

    public function testStockQuantity(): void
    {
        $product = new Product(
            id: 'prod_1',
            name: 'Product',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
            stockQuantity: 50,
        );

        self::assertSame(50, $product->getStockQuantity());
    }

    public function testIsInStock(): void
    {
        $inStockProduct = new Product(
            id: 'prod_1',
            name: 'Product',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-001',
            stockQuantity: 10,
        );

        $outOfStockProduct = new Product(
            id: 'prod_2',
            name: 'Product',
            description: 'Desc',
            price: new Money(1000, Currency::USD),
            sku: 'SKU-002',
            stockQuantity: 0,
        );

        self::assertTrue($inStockProduct->isInStock());
        self::assertFalse($outOfStockProduct->isInStock());
    }
}
