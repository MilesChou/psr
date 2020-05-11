# PSR-7 HTTP Message

Request / Response supports custom assertion.

```php
use MilesChou\Psr\Http\Message\Testing\TestRequest;
use MilesChou\Psr\Http\Message\Testing\TestResponse;

$actual = (new Psr7Request())
    ->withMethod('POST')
    ->withHeader('Foo', 'Bar');

(new TestRequest($actual))
    ->assertMethod('POST')
    ->assertHeader('Foo', 'Bar');

$actual = (new Psr7Response())
    ->withStatusCode(401);

(new TestResponse($actual))
    ->assertUnauthorized();
```
