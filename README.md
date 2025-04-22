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

Run the installation command and follow the prompts:

```bash
php artisan nested-comments:install
```

Adjust the configuration file as necessary, then run migrations.

`That's it! You are now ready to add nested comments

## Usage
At the very basic level, this package is simply a Livewire Component that takes in a model record which is commentable. Follow the following steps to prepare your model to be commentable or reactable:
1. Add the `HasComments` trait to your model
```php

use Coolsam\NestedComments\Traits\HasComments;

class Post extends Model
{
    use HasComments;

    // ...
}

```
2. If you would like to be able to react to your model directly as well, add the `HasReactions` trait to your model
```php
use Coolsam\NestedComments\Traits\HasReactions;

class Post extends Model
{
    use HasReactions;

    // ...
}
```
3. You can now access the comments and reactions of your model using the following methods:

### Using the Comments Infolist Entry

```php
public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Basic Details')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('start_date')
                            ->dateTime(),
                        TextEntry::make('end_date')
                            ->dateTime(),
                        TextEntry::make('created_at')
                            ->dateTime(),
                    ]),

                \Coolsam\NestedComments\Filament\Infolists\CommentsEntry::make('comments'),
            ]);
    }
```

### Using the Comments Widget inside a Resource Page (e.g EditRecord) which has the $record property

```php
class EditConference extends EditRecord
{
    protected static string $resource = ConferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            \Coolsam\NestedComments\Filament\Widgets\CommentsWidget::class,
        ];
    }
}
```

### Using the Comments Widget in a custom Filament Page (You have to pass $record manually)

```php
// NOTE: It's up to you how to get your record, as long as you pass it to the widget
public function getRecord(): ?Conference
{
    return Conference::latest()->first();
}

protected function getFooterWidgets(): array
{
    return [
        CommentsWidget::make(['record' => $this->getRecord()])
    ];
}
```

### Using the Comments Page Action in a Resource Page (which interacts with $record)

```php
namespace App\Filament\Resources\ConferenceResource\Pages;

use App\Filament\Resources\ConferenceResource;
use Coolsam\NestedComments\Filament\Actions\CommentsAction;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Database\Eloquent\Model;

class ViewConference extends ViewRecord
{
    protected static string $resource = ConferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CommentsAction::make()
                ->badgeColor('danger')
                ->badge(fn(Model $record) => $record->getAttribute('comments_count')),
            Actions\EditAction::make(),
        ];
    }
}
```
### Using the Comments Page Action in a custom Filament Page (You have to pass $record manually)
In this case you will have to pass the record attribute manually.

```php
protected function getHeaderActions(): array
{
    return [
        CommentsAction::make()
            ->record($this->getRecord()) // Define the logic for getting your record e.g in $this->getRecord()
            ->badgeColor('danger')
            ->badge(fn(Model $record) => $record->getAttribute('comments_count')),
        Actions\EditAction::make(),
    ];
}
```

### Using the Comments Table Action

```php
public static function table(Table $table): Table
{
    return $table
        ->columns([
            // ... Columns
        ])
        ->actions([
            \Coolsam\NestedComments\Filament\Tables\Actions\CommentsAction::make()
                ->button()
                ->badgeColor('danger')
                ->badge(fn(Conference $record) => $record->getAttribute('comments_count')),
            // ... Other actions
        ]);
}
```
### Using the Comments Blade Component ANYWHERE!
This unlocks incredible possibilities. It allows you to render your comments even in your own frontend blade page. All you have to do is simply pass the commentable `$record` to the blade component
```php
$record = Conference::find(1); // Get your record from the database then,

<x-nested-comments::comments :record="$record"/>
```

Alternatively, you could use the Livewire component if you prefer.
```php
$record = Conference::find(1); // Get your record from the database then,

<livewire:nested-comments::comments :record="$record"/>
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
