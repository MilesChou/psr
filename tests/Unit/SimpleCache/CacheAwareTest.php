<?php

declare(strict_types=1);

namespace Tests\Unit\SimpleCache;

use MilesChou\Psr\SimpleCache\CacheAwareTrait;
use PHPUnit\Framework\TestCase;
use Psr\SimpleCache\InvalidArgumentException;

class CacheAwareTest extends TestCase
{
    /**
     * @test
     * @dataProvider getInvalidTtlCases
     */
    public function shouldThrowExceptionWhenGivenInvalidTTL($invalidTtl): void
    {
        $this->expectException(InvalidArgumentException::class);

        $target = $this->getMockForTrait(CacheAwareTrait::class);
        $target->setTtl($invalidTtl);
    }

    public function getInvalidTtlCases(): array
    {
        return [
            [false],
            [true],
            ['value'],
            [[]],
            [new \stdClass],
        ];
    }

    public function getValidTtlCases(): array
    {
        return [
            [null],
            [86400],
            [new \DateInterval('PT1S')],
        ];
    }

    /**
     * @test
     * @dataProvider getValidTtlCases
     */
    public function shouldGetTtlWhenGivenValidTTL($excepted): void
    {
        $target = $this->getMockForTrait(CacheAwareTrait::class);
        $target->setTtl($excepted);

        $actual = $target->getTtl();

        $this->assertSame($excepted, $actual);
    }

    /**
     * @test
     */
    public function shouldGetDefaultTtlWhenDoNotSetTTL(): void
    {
        $excepted = 60;

        $target = $this->getMockForTrait(CacheAwareTrait::class);
        $target->expects($this->any())
            ->method('getDefaultTtl')
            ->will($this->returnValue($excepted));

        $actual = $target->getTtl();

        $this->assertSame($excepted, $actual);
    }
}
