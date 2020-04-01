# PSR-17 HTTP Factory

## Use case for PSR-17 HTTP Factory wrapper

When we write a package but we don't want limit on any PSR-17 library. For example: [`mileschou/mocker`](https://github.com/MilesChou/mocker).

### PSR-17 HTTP Factory

Auto detect for HTTP Factory implementation.

```php
use MilesChou\Psr\Http\Message\ResponseFactory;

$factory = new ResponseFactory();

// return Laminas Response when install Laminas only
$factory->createResponse();

// return Nyholm Response when install Nyholm only
$factory->createResponse();
```

Following is support library and order.

* [`laminas/laminas-diactoros`](https://github.com/laminas/laminas-diactoros) ^2.0
* [`nyholm/psr7`](https://github.com/Nyholm/psr7) ^1.0
* [`http-interop/http-factory-guzzle`](https://github.com/http-interop/http-factory-guzzle) ^1.0
* [`http-interop/http-factory-slim`](https://github.com/http-interop/http-factory-slim) ^2.0

Custom / force specify the factory instance.

```php
use Laminas\Diactoros\ResponseFactory as LaminasResponseFactory;
use MilesChou\Psr\Http\Message\ResponseFactory;

$factory = new ResponseFactory(new LaminasResponseFactory());

// return Laminas Response when install Laminas only
$factory->createResponse();
```

> [More implementations](https://packagist.org/providers/psr/http-factory-implementation)
