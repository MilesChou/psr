<?php

namespace MilesChou\Psr\Http\Message\Testing;

use BadMethodCallException;
use PHPUnit\Framework\Assert as PHPUnit;
use Psr\Http\Message\RequestInterface;

/**
 * @mixin RequestInterface
 */
class TestRequest
{
    /**
     * @var RequestInterface
     */
    public $baseRequest;

    /**
     * Create a new TestRequest from PSR-7 request.
     *
     * @param RequestInterface $request
     * @return TestRequest
     */
    public static function fromBaseRequest($request): TestRequest
    {
        return new self($request);
    }

    /**
     * @param RequestInterface $request
     */
    public function __construct($request)
    {
        $this->baseRequest = $request;
    }

    /**
     * Handle dynamic calls into macros or pass missing methods to the base request.
     *
     * @param string $method
     * @param array<mixed> $args
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (method_exists($this->baseRequest, $method)) {
            return $this->baseRequest->{$method}(...$args);
        }

        $message = sprintf('Call to undefined method %s::%s()', static::class, $method);

        throw new BadMethodCallException($message);
    }

    /**
     * Asserts that the request does not contains the given header.
     *
     * @param string $username
     * @param string $password
     * @return $this
     * @see https://github.com/laravel/framework/blob/v7.3.0/src/Illuminate/Testing/TestResponse.php#L396
     */
    public function assertBasicAuthentication(string $username, string $password): self
    {
        $credentials = base64_encode("{$username}:{$password}");

        $this->assertHeader('Authorization', "Basic {$credentials}");

        return $this;
    }

    /**
     * Asserts that the request does not contains the given header.
     *
     * @param string $value
     * @return $this
     * @see https://github.com/laravel/framework/blob/v7.3.0/src/Illuminate/Testing/TestResponse.php#L396
     */
    public function assertBodyContains(string $value): self
    {
        PHPUnit::assertStringContainsString($value, $this->getContent());

        return $this;
    }

    /**
     * Asserts that the request does not contains the given header.
     *
     * @param string $value
     * @return $this
     * @see https://github.com/laravel/framework/blob/v7.3.0/src/Illuminate/Testing/TestResponse.php#L396
     */
    public function assertContentType(string $value): self
    {
        $actual = $this->baseRequest->getHeaderLine('Content-type');

        PHPUnit::assertStringContainsString(
            $value,
            $actual,
            "Header Content-type value [{$actual}] does not contains [{$value}]."
        );

        return $this;
    }

    /**
     * Asserts that the request does not contains the given header.
     *
     * @return $this
     * @see https://github.com/laravel/framework/blob/v7.3.0/src/Illuminate/Testing/TestResponse.php#L396
     */
    public function assertContentTypeIsJson(): self
    {
        return $this->assertContentType('application/json');
    }

    /**
     * Asserts that the request contains the given header and equals the optional value.
     *
     * @param string $name
     * @param mixed $value
     * @return $this
     * @see https://github.com/laravel/framework/blob/v7.3.0/src/Illuminate/Testing/TestResponse.php#L217
     */
    public function assertHeader($name, $value = null): self
    {
        PHPUnit::assertTrue(
            $this->hasHeader($name),
            "Header [{$name}] not present on request."
        );

        if ($value !== null) {
            $actual = $this->baseRequest->getHeaderLine($name);

            PHPUnit::assertSame(
                $value,
                $actual,
                "Header [{$name}] was found, but value [{$actual}] does not match [{$value}]."
            );
        }

        return $this;
    }

    /**
     * Asserts that the request does not contains the given header.
     *
     * @param string $name
     * @return $this
     * @see https://github.com/laravel/framework/blob/v7.3.0/src/Illuminate/Testing/TestResponse.php#L241
     */
    public function assertHeaderMissing($name): self
    {
        PHPUnit::assertFalse(
            $this->hasHeader($name),
            "Unexpected header [{$name}] is present on request."
        );

        return $this;
    }

    /**
     * Assert that the request method.
     *
     * @param string $expected
     * @return $this
     */
    public function assertMethod(string $expected): self
    {
        $actual = $this->baseRequest->getMethod();

        PHPUnit::assertSame(
            $expected,
            $actual,
            "Request method '{$actual}' is not '{$expected}'."
        );

        return $this;
    }

    /**
     * @param string $expected
     * @return $this
     */
    public function assertProtocolVersion(string $expected): self
    {
        $actual = $this->baseRequest->getProtocolVersion();

        PHPUnit::assertSame(
            $expected,
            $actual,
            "Request protocol version '{$actual}' is not '{$expected}'."
        );

        return $this;
    }

    /**
     * @param string $expected
     * @return $this
     */
    public function assertRequestTarget(string $expected): self
    {
        $actual = $this->baseRequest->getRequestTarget();

        PHPUnit::assertSame(
            $expected,
            $actual,
            "Request target '{$actual}' is not '{$expected}'."
        );

        return $this;
    }

    /**
     * Assert that the request uri.
     *
     * @param string $expected
     * @return $this
     */
    public function assertUri(string $expected): self
    {
        $actual = (string)$this->baseRequest->getUri();

        PHPUnit::assertSame(
            $expected,
            $actual,
            "Request uri '{$actual}' is not '{$expected}'."
        );

        return $this;
    }

    /**
     * Assert that the request uri.
     *
     * @param string $expected
     * @return $this
     */
    public function assertUriContains(string $expected): self
    {
        $actual = (string)$this->baseRequest->getUri();

        PHPUnit::assertStringContainsString(
            $expected,
            $actual,
            "Request uri '{$actual}' is not contains '{$expected}'."
        );

        return $this;
    }

    /**
     * Get request body content
     *
     * @return string
     */
    public function getContent(): string
    {
        return (string)$this->baseRequest->getBody();
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasHeader(string $name): bool
    {
        return '' !== $this->baseRequest->getHeaderLine($name);
    }
}
