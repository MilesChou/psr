<?php

namespace MilesChou\Psr\Http\Client\Testing;

use MilesChou\Psr\Http\Client\HttpClientInterface;
use MilesChou\Psr\Http\Message\Testing\TestRequest;
use MilesChou\Psr\Http\Message\Traits\RequestFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\ResponseFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\ServerRequestFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\StreamFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\UploadedFileFactoryDetector;
use MilesChou\Psr\Http\Message\Traits\UriFactoryDetector;
use OutOfBoundsException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use RuntimeException;
use Throwable;

/**
 * MockClient
 *
 * Implement HttpClientInterface. It can both mock to ClientInterface and HttpClientInterface.
 */
class MockClient implements HttpClientInterface
{
    use RequestFactoryDetector;
    use ResponseFactoryDetector;
    use ServerRequestFactoryDetector;
    use StreamFactoryDetector;
    use UploadedFileFactoryDetector;
    use UriFactoryDetector;

    /**
     * @var array<RequestInterface>
     */
    public $requests = [];

    /**
     * @var ResponseInterface|null
     */
    private $alwaysReturn;

    /**
     * @var array<ResponseInterface|Throwable>
     */
    private $queue = [];

    /**
     * @param ResponseFactoryInterface|null $responseFactory
     * @param StreamFactoryInterface|null $streamFactory
     * @return MockClient
     */
    public static function createAlwaysReturnEmptyResponse($responseFactory = null, $streamFactory = null): MockClient
    {
        $mock = new self([], $responseFactory, $streamFactory);

        return $mock->alwaysReturnEmptyResponse();
    }

    /**
     * @param ResponseInterface|Throwable|array<ResponseInterface|Throwable> $queue
     * @param ResponseFactoryInterface|null $responseFactory
     * @param StreamFactoryInterface|null $streamFactory
     */
    public function __construct($queue = [], $responseFactory = null, $streamFactory = null)
    {
        if (!is_array($queue)) {
            $queue = [$queue];
        }

        $this->appendQueueList($queue);

        $this->setResponseFactory($responseFactory);
        $this->setStreamFactory($streamFactory);
    }

    /**
     * @return $this
     */
    public function alwaysReturnEmptyResponse(): self
    {
        return $this->alwaysReturn($this->createResponse());
    }

    /**
     * @param ResponseInterface $response
     * @return $this
     */
    public function alwaysReturn(ResponseInterface $response): self
    {
        $this->alwaysReturn = $response;

        return $this;
    }

    /**
     * @param ResponseInterface|Throwable $item
     * @return $this
     */
    public function appendQueue($item): self
    {
        if ($item instanceof ResponseInterface) {
            return $this->appendResponse($item);
        }

        // Throwable
        return $this->appendThrowable($item);
    }

    /**
     * @param array<ResponseInterface|Throwable> $items
     * @return $this
     */
    public function appendQueueList(array $items): self
    {
        foreach ($items as $item) {
            $this->appendQueue($item);
        }

        return $this;
    }

    /**
     * @param ResponseInterface $response
     * @return $this
     */
    public function appendResponse(ResponseInterface $response): self
    {
        $this->queue[] = $response;

        return $this;
    }

    /**
     * @param Throwable $exception
     * @return $this
     */
    public function appendThrowable(Throwable $exception): self
    {
        $this->queue[] = $exception;

        return $this;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function appendEmptyResponse(int $status = 200): self
    {
        return $this->appendResponseWith('', $status);
    }

    /**
     * @param string $body
     * @param int $status
     * @param array<mixed> $headers
     * @return $this
     */
    public function appendResponseWith(string $body = '', int $status = 200, array $headers = []): self
    {
        return $this->appendResponse($this->buildResponse($body, $status, $headers));
    }

    /**
     * @param mixed $data
     * @param int $status
     * @param array<mixed> $headers
     * @return $this
     */
    public function appendResponseWithJson($data = [], int $status = 200, array $headers = []): self
    {
        return $this->appendResponseWith((string)json_encode($data), $status, $headers);
    }

    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        $this->requests[] = $request;

        if (null !== $this->alwaysReturn) {
            return $this->alwaysReturn;
        }

        $instance = array_shift($this->queue);

        if ($instance instanceof ResponseInterface) {
            return $instance;
        }

        if ($instance instanceof Throwable) {
            throw $instance;
        }

        throw new RuntimeException('Queue is empty');
    }

    public function hasRequests(): bool
    {
        return count($this->requests) > 0;
    }

    /**
     * @param int $index
     * @return TestRequest
     */
    public function testRequest(int $index = 0): TestRequest
    {
        if (!isset($this->requests[$index])) {
            throw new OutOfBoundsException("Request index '{$index}' is not found");
        }

        return new TestRequest($this->requests[$index]);
    }

    /**
     * Build PSR-7 response instance
     *
     * @param string $body
     * @param int $status
     * @param array<mixed> $headers
     * @return ResponseInterface
     */
    private function buildResponse(string $body = '', int $status = 200, array $headers = []): ResponseInterface
    {
        $response = $this->createResponse($status)
            ->withBody($this->createStream($body));

        foreach ($headers as $key => $header) {
            $response = $response->withHeader($key, $header);
        }

        return $response;
    }
}
