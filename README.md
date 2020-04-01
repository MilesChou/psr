# PSR Support Library

[![Build Status](https://travis-ci.com/MilesChou/psr.svg?branch=master)](https://travis-ci.com/MilesChou/psr)
[![codecov](https://codecov.io/gh/MilesChou/psr/branch/master/graph/badge.svg)](https://codecov.io/gh/MilesChou/psr)
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/3412605912a942b6b60a934685615cf4)](https://www.codacy.com/manual/MilesChou/psr)
[![Latest Stable Version](https://poser.pugx.org/MilesChou/psr/v/stable)](https://packagist.org/packages/MilesChou/psr)
[![Total Downloads](https://poser.pugx.org/MilesChou/psr/d/total.svg)](https://packagist.org/packages/MilesChou/psr)
[![License](https://poser.pugx.org/MilesChou/psr/license)](https://packagist.org/packages/MilesChou/psr)

The support library for PSR.

## PSR-17 HTTP Factory

Auto detector for HTTP Factory.

```php
use MilesChou\Psr\Http\Message\ResponseFactory;

$factory = new ResponseFactory();

// return Laminas Response when install Laminas only
$factory->createResponse();

// return Nyholm Response when install Nyholm only
$factory->createResponse();
```

Custom / force specify the factory instance.

```php
use Laminas\Diactoros\ResponseFactory as LaminasResponseFactory;
use MilesChou\Psr\Http\Message\ResponseFactory;

$factory = new ResponseFactory(new LaminasResponseFactory());

// return Laminas Response when install Laminas only
$factory->createResponse();
```

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
