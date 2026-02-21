<?php

namespace QuimiCommerce\Tests\Unit;

use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    protected function assertValueObjectEquals(mixed $expected, mixed $actual): void
    {
        self::assertEquals($expected, $actual);
    }
}
