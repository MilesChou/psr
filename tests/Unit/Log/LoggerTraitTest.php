<?php

namespace Tests\Unit\Log;

use MilesChou\Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggerTraitTest extends TestCase
{
    use LoggerAwareTrait;

    /**
     * @test
     */
    public function shouldNotCallLoggerInstanceWhenNotSetLogger(): void
    {
        $logger = $this->getMockBuilder(LoggerInterface::class)
            ->getMock();

        $logger->expects($this->once())
            ->method('log');

        $this->setLogger($logger);
        $this->log(LogLevel::INFO, 'some-log');
    }
}
