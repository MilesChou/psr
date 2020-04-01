<?php

declare(strict_types=1);

namespace Tests\Unit\SimpleCache;

use DateInterval;
use DateTimeImmutable;
use MilesChou\Psr\SimpleCache\Helper;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;
use stdClass;

class HelperTest extends TestCase
{
    public function getTtlCases(): array
    {
        return [
            [null, null],
            [new DateInterval('PT1H'), 3600],
            [3600, 3600],
        ];
    }

    /**
     * @test
     * @dataProvider getTtlCases
     */
    public function shouldGetExceptedResultWhenCallNormalizeTtl($ttl, $excepted): void
    {
        $actual = Helper::normalizeTtl($ttl);

        $this->assertSame($excepted, $actual);
    }

    /**
     * @test
     */
    public function shouldGetExceptedResultWhenCallNormalizeExpireAtWithInt(): void
    {
        $ttl = 3600;
        $excepted = time() + $ttl;

        $actual = Helper::normalizeExpireAt($ttl);

        $this->assertSame($excepted, $actual);
    }

    /**
     * @test
     */
    public function shouldGetExceptedResultWhenCallNormalizeExpireAtWithDateInterval(): void
    {
        $ttl = new DateInterval('PT1H');
        $excepted = (new DateTimeImmutable)->add($ttl)->getTimestamp();

        $actual = Helper::normalizeExpireAt($ttl);

        $this->assertSame($excepted, $actual);
    }

    /**
     * @test
     */
    public function shouldGetExceptedResultWhenCallNormalizeExpireAtWithNull(): void
    {
        $ttl = $excepted = null;

        $actual = Helper::normalizeExpireAt($ttl);

        $this->assertSame($excepted, $actual);
    }

    public function getInvalidTtlCases(): array
    {
        return [
            ['string'],
            [1.23],
            [true],
            [[]],
            [new \stdClass],
        ];
    }

    /**
     * @test
     * @dataProvider getInvalidTtlCases
     */
    public function shouldThrowExceptionWhenCallNormalizeTtlWith($invalidTtl): void
    {
        $this->expectException(InvalidArgumentException::class);

        Helper::normalizeTtl($invalidTtl);
    }

    /**
     * @test
     * @dataProvider getInvalidTtlCases
     */
    public function shouldThrowExceptionWhenCallNormalizeExpireAtWith($invalidTtl): void
    {
        $this->expectException(InvalidArgumentException::class);

        Helper::normalizeExpireAt($invalidTtl);
    }

    public function getInvalidKeys(): array
    {
        return [
            [123],
            [123.123],
            [false],
            [true],
            [[123, 456]],
            [new \stdClass],
        ];
    }

    /**
     * @test
     * @dataProvider getInvalidKeys
     */
    public function shouldThrowExceptionWhenCheckStringTypeWith($invalidKey): void
    {
        $this->expectException(InvalidArgumentException::class);

        Helper::checkStringType($invalidKey);
    }

    /**
     * @test
     */
    public function shouldBeOkayWhenCheckTraversableTypeWithTraversableInput(): void
    {
        Helper::checkTraversableType($this->getMockBuilder(\Traversable::class)->getMock());
        Helper::checkTraversableType(new \ArrayObject());

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenCheckTraversableTypeWithNotTraversableInput(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Helper::checkTraversableType('test');
    }

    public function validTtlType(): array
    {
        return [
            [null],
            [3600],
            [new DateInterval('PT1H')],
        ];
    }

    /**
     * @test
     * @dataProvider validTtlType
     */
    public function shouldBeOkayWhenCheckTtlTypeWith($validInput): void
    {
        Helper::checkTtlType($validInput);

        $this->assertTrue(true);
    }

    public function invalidTtlType(): array
    {
        return [
            ['string'],
            [0.5],
            [false],
            [[]],
            [new stdClass()],
        ];
    }

    /**
     * @test
     * @dataProvider invalidTtlType
     */
    public function shouldThrowExceptionWhenCheckTtlTypeWith($invalidInput): void
    {
        $this->expectException(InvalidArgumentException::class);

        Helper::checkTtlType($invalidInput);
    }
}
