# PSR-18 HTTP Client

## Usage for `ClientManager`

Use case: when many client will be managed, e.g. different proxy config or different implementation.

Create manager with default client.

```php
use MilesChou\Psr\Http\Client\ClientManager;

$client = new ClientManager(new Psr18Client());

$client->sendRequest(new Psr7Request()); // Use as a PSR-18 client 
```

Add driver and call.

```php
use MilesChou\Psr\Http\Client\ClientManager;

$client = new ClientManager(new Psr18Client());

$client->add('foo', new AnotherPsr18Client()); // Register

$client->driver('foo')->sendRequest(new Psr7Request()); // Call by AnotherPsr18Client
```

`HttpClientManager` is extends `ClientManager` and implement `HttpFactoryInterface`.

## Usage for `MockClient`

Build MockClient and setup behavior.

```php
use MilesChou\Psr\Http\Client\Testing\MockClient;

$expected = new Psr7Response();

$mock = new MockClient($expected);

$mock->sendRequest(new Psr7Request()); // Will return $expected
```

MockClient supports many helper for setup responses.

```php
use MilesChou\Psr\Http\Client\Testing\MockClient;

$mock = new MockClient();
$mock->appendEmptyResponse();
$mock->appendResponseWith('string body');
$mock->appendResponseWithJson(['foo' => 'bar']);

$mock->sendRequest(new Psr7Request()); // Will return empty response
$mock->sendRequest(new Psr7Request()); // Will return 'string body'
$mock->sendRequest(new Psr7Request()); // Will return JSON body
```

MockClient can append Exception, too.

```php
use MilesChou\Psr\Http\Client\Testing\MockClient;

$mock = new MockClient();
$mock->appendThrowable(new \Exception());

$mock->sendRequest(new Psr7Request()); // Will throw exception
```

MockClient supports use case for Spy.

```php
use MilesChou\Psr\Http\Client\Testing\MockClient;

$expected = new Psr7Request();

$mock = MockClient::createAlwaysReturnEmptyResponse(); // Use this factory if don't care response

$mock->sendRequest($expected);

$mock->requests[0]; // is equals $expected
```

Request supports custom assertion, see [PSR-7 HTTP Message](psr7-http-message.md).

```php
use MilesChou\Psr\Http\Client\Testing\MockClient;

$expected = (new Psr7Request())
    ->withMethod('POST')
    ->withHeader('Foo', 'Bar');

$mock = new MockClient(new Psr7Response());

$mock->sendRequest($expected);

$mock->testRequest(0)
    ->assertMethod('POST')
    ->assertHeader('Foo', 'Bar');
```
