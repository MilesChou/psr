<?php

namespace MilesChou\Psr\Http\Message\Testing;

use BadMethodCallException;
use MilesChou\Psr\Http\Message\Traits\ResponseProxy;
use PHPUnit\Framework\Assert as PHPUnit;
use Psr\Http\Message\ResponseInterface;

/**
 * Just like TestResponse in Laravel, but it use on PSR-7 Response
 *
 * @see https://github.com/laravel/framework/blob/v7.4.0/src/Illuminate/Testing/TestResponse.php
 */
class TestResponse implements ResponseInterface
{
    use ResponseProxy;

    /**
     * Create a new TestRequest from PSR-7 request.
     *
     * @param ResponseInterface $response
     *
     * @return TestResponse
     */
    public static function fromBaseResponse(ResponseInterface $response): TestResponse
    {
        return new self($response);
    }

    /**
     * @param ResponseInterface $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Handle dynamic calls into macros or pass missing methods to the base response.
     *
     * @param string $method
     * @param array<mixed> $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        if (method_exists($this->response, $method)) {
            return $this->response->{$method}(...$args);
        }

        $message = sprintf('Call to undefined method %s::%s()', static::class, $method);

        throw new BadMethodCallException($message);
    }

    /**
     * Assert that the response has a successful status code.
     *
     * @return $this
     */
    public function assertSuccessful(): self
    {
        $actual = $this->response->getStatusCode();

        PHPUnit::assertTrue(
            $this->isSuccessful(),
            "Response status code [{$actual}] is not a successful status code."
        );

        return $this;
    }

    /**
     * Assert that the response has a 200 status code.
     *
     * @return $this
     */
    public function assertOk(): self
    {
        $actual = $this->response->getStatusCode();

        PHPUnit::assertSame(
            200,
            $actual,
            "Response status code [{$actual}] does not match expected 200 status code."
        );

        return $this;
    }

    /**
     * Assert that the response has a 201 status code.
     *
     * @return $this
     */
    public function assertCreated(): self
    {
        $actual = $this->response->getStatusCode();

        PHPUnit::assertSame(
            201,
            $actual,
            "Response status code [{$actual}] does not match expected 201 status code."
        );

        return $this;
    }

    /**
     * Assert that the response has the given status code and no content.
     *
     * @param int $status
     *
     * @return $this
     */
    public function assertNoContent($status = 204): self
    {
        $this->assertStatus($status);

        PHPUnit::assertEmpty($this->getContent(), 'Response content is not empty.');

        return $this;
    }

    /**
     * Assert that the response has a not found status code.
     *
     * @return $this
     */
    public function assertNotFound(): self
    {
        $actual = $this->response->getStatusCode();

        PHPUnit::assertSame(
            404,
            $actual,
            'Response status code [' . $this->getStatusCode() . '] is not a not found status code.'
        );

        return $this;
    }

    /**
     * Assert that the response has a forbidden status code.
     *
     * @return $this
     */
    public function assertForbidden(): self
    {
        $actual = $this->response->getStatusCode();

        PHPUnit::assertSame(
            403,
            $actual,
            'Response status code [' . $this->getStatusCode() . '] is not a forbidden status code.'
        );

        return $this;
    }

    /**
     * Assert that the response has an unauthorized status code.
     *
     * @return $this
     */
    public function assertUnauthorized(): self
    {
        $actual = $this->getStatusCode();

        PHPUnit::assertSame(
            401,
            $actual,
            "Response status code [{$actual}] is not an unauthorized status code."
        );

        return $this;
    }

    /**
     * Assert that the response has the given status code.
     *
     * @param int $status
     *
     * @return $this
     */
    public function assertStatus($status): self
    {
        $actual = $this->response->getStatusCode();

        PHPUnit::assertSame(
            $actual,
            $status,
            "Expected status code {$status} but received {$actual}."
        );

        return $this;
    }

    /**
     * Assert whether the response is redirecting to a given URI.
     *
     * @param string|null $uri
     *
     * @return $this
     */
    public function assertRedirect($uri = null): self
    {
        PHPUnit::assertTrue(
            $this->isRedirect(),
            'Response status code [' . $this->getStatusCode() . '] is not a redirect status code.'
        );

        if ($uri !== null) {
            $this->assertLocation($uri);
        }

        return $this;
    }

    /**
     * Assert that the current location header matches the given URI.
     *
     * @param string $uri
     *
     * @return $this
     */
    public function assertLocation($uri): self
    {
        PHPUnit::assertStringContainsString(
            $uri,
            $this->response->getHeaderLine('Location')
        );

        return $this;
    }

    /**
     * Assert that the given string is contained within the response.
     *
     * @param string $value
     *
     * @return $this
     */
    public function assertSee($value): self
    {
        PHPUnit::assertStringContainsString($value, $this->getContent());

        return $this;
    }

    /**
     * Asserts that the request contains the given header and equals the optional value.
     *
     * @param string $name
     * @param mixed $value
     *
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
            $actual = $this->response->getHeaderLine($name);

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
     *
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
     * Get request body content
     *
     * @return string
     */
    public function getContent(): string
    {
        return (string)$this->response->getBody();
    }

    /**
     * Return true when code is 2xx
     *
     * @return bool
     */
    public function isSuccessful(): bool
    {
        $code = $this->response->getStatusCode();

        return 200 <= $code || 300 > $code;
    }

    /**
     * Return true when code is 23xx
     *
     * @return bool
     */
    private function isRedirect(): bool
    {
        $code = $this->response->getStatusCode();

        return 300 <= $code || 400 > $code;
    }
}
