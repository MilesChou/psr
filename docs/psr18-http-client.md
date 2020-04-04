# PSR-18 HTTP Client

Use case: when many client will be managed, e.g. different proxy config or different implementation.

## Usage

Create manager with default client.

```php
use MilesChou\Psr\Http\Client\HttpClientManager;

$client = new HttpClientManager(new Psr18Client());

$client->sendRequest(new Psr7Request()); // Use as a PSR-18 client 
```

Add driver and call.

```php
use MilesChou\Psr\Http\Client\HttpClientManager;

$client = new HttpClientManager(new Psr18Client());

$client->add('foo', new AnotherPsr18Client()); // Register

$client->driver('foo')->sendRequest(new Psr7Request()); // Call by AnotherPsr18Client
```
