<?php

namespace MilesChou\Psr\Http\Message\Testing;

use MilesChou\Psr\Http\Message\Traits\RequestProxy;
use PHPUnit\Framework\Assert as PHPUnit;
use Psr\Http\Message\RequestInterface;

class TestRequest implements RequestInterface
{
    use RequestProxy;

    /**
     * Create a new TestRequest from PSR-7 request.
     *
     * @param RequestInterface $request
     * @return TestRequest
     */
    public static function fromBaseRequest(RequestInterface $request): TestRequest
    {
        return new self($request);
    }

    /**
     * @param RequestInterface $request
     */
    public function __construct($request)
    {
        $this->request = $request;
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
        $actual = $this->request->getHeaderLine('Content-type');

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
            $actual = $this->request->getHeaderLine($name);

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
        $actual = $this->request->getMethod();

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
        $actual = $this->request->getProtocolVersion();

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
        $actual = $this->request->getRequestTarget();

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
        $actual = (string)$this->request->getUri();

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
        $actual = (string)$this->request->getUri();

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
        return (string)$this->request->getBody();
    }
}
