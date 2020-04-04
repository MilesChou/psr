# PSR-7 HTTP Message

Request / Response supports custom assertion.

```php
use MilesChou\Psr\Http\Message\Testing\TestRequest;
use MilesChou\Psr\Http\Message\Testing\TestResponse;

$expected = (new Psr7Request())
    ->withMethod('POST')
    ->withHeader('Foo', 'Bar');

(new TestRequest($expected))
    ->assertMethod('POST')
    ->assertHeader('Foo', 'Bar');

$expected = (new Psr7Response())
    ->withStatusCode(401);

(new TestResponse($expected))
    ->assertUnauthorized();
```
