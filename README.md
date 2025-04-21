# Add Nested comments/replies to filament forms, infolists and resources

[![Latest Version on Packagist](https://img.shields.io/packagist/v/coolsam/nested-comments.svg?style=flat-square)](https://packagist.org/packages/coolsam/nested-comments)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/coolsam726/nested-comments/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/coolsam726/nested-comments/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/coolsam726/nested-comments/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/coolsam726/nested-comments/actions?query=workflow%3A"Fix+PHP+Code+Styling"+branch%3Amain)
[![GitHub PHPStan Action Status](https://img.shields.io/github/actions/workflow/status/coolsam726/nested-comments/phpstan.yml?branch=main&label=phpstan&style=flat-square)](https://github.com/coolsam726/nested-comments/actions?query=workflow%3APHPStan+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/coolsam/nested-comments.svg?style=flat-square)](https://packagist.org/packages/coolsam/nested-comments)



This package allows you to incorporate comments and replies in your Filament forms, infolists, pages, widgets etc, or even simply in your livewire components. Comment replies can be nested as deep as you want, using the Nested Set data structure. Additionally, the package comes with a Reactions feature to enable your users to react to any of your models (e.g comments or posts) with selected emoji reactions.

![image](https://github.com/user-attachments/assets/e4ff32b3-0eb9-4ad4-8edb-de91b1940e13)


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

Run the installation command and follow the prompts:

```bash
php artisan nested-comments:install
```

Adjust the configuration file as necessary, then run migrations.

`That's it! You are now ready to add nested comments

## Usage
**WIP**
```php

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
