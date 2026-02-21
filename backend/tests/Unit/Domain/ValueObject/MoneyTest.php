<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\ValueObject;

use PHPUnit\Framework\TestCase;
use QuimiCommerce\Domain\ValueObject\Currency;
use QuimiCommerce\Domain\ValueObject\Money;

class MoneyTest extends TestCase
{
    public function testCreateMoneyWithAmountAndCurrency(): void
    {
        $money = new Money(1000, Currency::USD);

        self::assertSame(1000, $money->getAmount());
        self::assertSame(Currency::USD, $money->getCurrency());
    }

    public function testMoneyEquality(): void
    {
        $money1 = new Money(1000, Currency::USD);
        $money2 = new Money(1000, Currency::USD);
        $money3 = new Money(1000, Currency::EUR);

        self::assertTrue($money1->equals($money2));
        self::assertFalse($money1->equals($money3));
    }

    public function testMoneyAddition(): void
    {
        $money1 = new Money(1000, Currency::USD);
        $money2 = new Money(500, Currency::USD);

        $result = $money1->add($money2);

        self::assertSame(1500, $result->getAmount());
        self::assertSame(Currency::USD, $result->getCurrency());
    }

    public function testMoneyAdditionWithDifferentCurrencyThrowsException(): void
    {
        $this->expectException(\DomainException::class);

        $money1 = new Money(1000, Currency::USD);
        $money2 = new Money(500, Currency::EUR);

        $money1->add($money2);
    }

    public function testMoneySubtraction(): void
    {
        $money1 = new Money(1000, Currency::USD);
        $money2 = new Money(300, Currency::USD);

        $result = $money1->subtract($money2);

        self::assertSame(700, $result->getAmount());
    }

    public function testMoneyMultiplication(): void
    {
        $money = new Money(1000, Currency::USD);

        $result = $money->multiply(1.5);

        self::assertSame(1500, $result->getAmount());
    }

    public function testFormatMoney(): void
    {
        $money = new Money(1999, Currency::USD);

        self::assertSame('$19.99', $money->format());
    }

    public function testFormatMXN(): void
    {
        $money = new Money(19990, Currency::MXN);

        self::assertSame('$199.90', $money->format());
    }

    public function testIsZero(): void
    {
        $zeroMoney = new Money(0, Currency::USD);
        $nonZeroMoney = new Money(100, Currency::USD);

        self::assertTrue($zeroMoney->isZero());
        self::assertFalse($nonZeroMoney->isZero());
    }

    public function testIsPositive(): void
    {
        $positiveMoney = new Money(100, Currency::USD);
        $negativeMoney = new Money(-100, Currency::USD);
        $zeroMoney = new Money(0, Currency::USD);

        self::assertTrue($positiveMoney->isPositive());
        self::assertFalse($negativeMoney->isPositive());
        self::assertFalse($zeroMoney->isPositive());
    }
}
