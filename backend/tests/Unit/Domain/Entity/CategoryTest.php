<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Entity;

use PHPUnit\Framework\TestCase;
use QuimiCommerce\Domain\Entity\Category;

class CategoryTest extends TestCase
{
    public function testCreateCategory(): void
    {
        $category = new Category(
            id: 'cat_123',
            name: 'Electronics',
            slug: 'electronics',
        );

        self::assertSame('cat_123', $category->getId());
        self::assertSame('Electronics', $category->getName());
        self::assertSame('electronics', $category->getSlug());
    }

    public function testCategoryEquality(): void
    {
        $category1 = new Category(
            id: 'cat_123',
            name: 'Electronics',
            slug: 'electronics',
        );

        $category2 = new Category(
            id: 'cat_123',
            name: 'Different Name',
            slug: 'different',
        );

        self::assertTrue($category1->equals($category2));
    }

    public function testCategoryNotEqualWithDifferentId(): void
    {
        $category1 = new Category(
            id: 'cat_123',
            name: 'Electronics',
            slug: 'electronics',
        );

        $category2 = new Category(
            id: 'cat_456',
            name: 'Electronics',
            slug: 'electronics',
        );

        self::assertFalse($category1->equals($category2));
    }

    public function testIsActive(): void
    {
        $activeCategory = new Category(
            id: 'cat_1',
            name: 'Active',
            slug: 'active',
            isActive: true,
        );

        $inactiveCategory = new Category(
            id: 'cat_2',
            name: 'Inactive',
            slug: 'inactive',
            isActive: false,
        );

        self::assertTrue($activeCategory->isActive());
        self::assertFalse($inactiveCategory->isActive());
    }

    public function testDefaultIsActive(): void
    {
        $category = new Category(
            id: 'cat_1',
            name: 'Category',
            slug: 'category',
        );

        self::assertTrue($category->isActive());
    }

    public function testDescription(): void
    {
        $category = new Category(
            id: 'cat_1',
            name: 'Electronics',
            slug: 'electronics',
            description: 'Electronic devices and accessories',
        );

        self::assertSame('Electronic devices and accessories', $category->getDescription());
    }

    public function testParentCategory(): void
    {
        $parent = new Category(
            id: 'cat_parent',
            name: 'Parent',
            slug: 'parent',
        );

        $child = new Category(
            id: 'cat_child',
            name: 'Child',
            slug: 'child',
            parentCategory: $parent,
        );

        self::assertSame($parent, $child->getParentCategory());
    }

    public function testHasChildren(): void
    {
        $categoryWithChildren = new Category(
            id: 'cat_1',
            name: 'Parent',
            slug: 'parent',
        );

        $categoryWithoutChildren = new Category(
            id: 'cat_2',
            name: 'Child',
            slug: 'child',
            parentCategory: $categoryWithChildren,
        );

        self::assertTrue($categoryWithChildren->hasChildren());
        self::assertFalse($categoryWithoutChildren->hasChildren());
    }
}
