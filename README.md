# Add Nested comments/replies to filament forms, infolists and resources

[![Latest Version on Packagist](https://img.shields.io/packagist/v/coolsam/nested-comments.svg?style=flat-square)](https://packagist.org/packages/coolsam/nested-comments)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/coolsam726/nested-comments/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/coolsam726/nested-comments/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/coolsam726/nested-comments/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/coolsam726/nested-comments/actions?query=workflow%3A"Fix+PHP+Code+Styling"+branch%3Amain)
[![GitHub PHPStan Action Status](https://img.shields.io/github/actions/workflow/status/coolsam726/nested-comments/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/coolsam726/nested-comments/actions?query=workflow%3APHPStan+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/coolsam/nested-comments.svg?style=flat-square)](https://packagist.org/packages/coolsam/nested-comments)



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require coolsam/nested-comments
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="nested-comments-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="nested-comments-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="nested-comments-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$nestedComments = new Coolsam\NestedComments();
echo $nestedComments->echoPhrase('Hello, Coolsam!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Sam Maosa](https://github.com/coolsam726)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
