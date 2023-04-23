# Rate Exchanges for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/oussamamater/rate-exchanger.svg?style=flat-square)](https://packagist.org/packages/oussamamater/rate-exchanger)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/oussamamater/rate-exchanger/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/oussamamater/rate-exchanger/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/oussamamater/rate-exchanger/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/oussamamater/rate-exchanger/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/oussamamater/rate-exchanger.svg?style=flat-square)](https://packagist.org/packages/oussamamater/rate-exchanger)

This Laravel package provides an easy way to convert currency rates using the latest exchange rates obtained from the European Central Bank API.

## Installation

You can install the package via composer:

```bash
composer require oussamamater/rate-exchanger
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="rate-exchanger-config"
```

## Usage

## Testing

```bash
vendor/bin/pest
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Oussama Mater](https://github.com/oussamamater)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
