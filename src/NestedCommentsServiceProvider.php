<?php

namespace Coolsam\NestedComments;

use Coolsam\NestedComments\Commands\NestedCommentsCommand;
use Coolsam\NestedComments\Http\Middleware\GuestCommentatorMiddleware;
use Coolsam\NestedComments\Livewire\AddComment;
use Coolsam\NestedComments\Livewire\CommentCard;
use Coolsam\NestedComments\Livewire\Comments;
use Coolsam\NestedComments\Testing\TestsNestedComments;
use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class NestedCommentsServiceProvider extends PackageServiceProvider
{
    public static string $name = 'nested-comments';

    public static string $viewNamespace = 'nested-comments';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasCommands($this->getCommands())
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->publishMigrations()
                    ->askToRunMigrations()
                    ->askToStarRepoOnGitHub('coolsam/nested-comments');
            });

        $configFileName = $package->shortName();

        if (file_exists($package->basePath("/../config/{$configFileName}.php"))) {
            $package->hasConfigFile();
        }

        if (file_exists($package->basePath('/../database/migrations'))) {
            $package->hasMigrations($this->getMigrations());
        }

        if (file_exists($package->basePath('/../resources/lang'))) {
            $package->hasTranslations();
        }

        if (file_exists($package->basePath('/../resources/views'))) {
            $package->hasViews(static::$viewNamespace);
        }
        if (file_exists($package->basePath('/../resources/views/components'))) {
            $package->hasViewComponents(static::$viewNamespace);
        }
    }

    public function packageRegistered(): void {}

    public function bootingPackage(): void
    {
        $this->app['router']->pushMiddlewareToGroup('web', GuestCommentatorMiddleware::class);
    }

    public function packageBooted(): void
    {
        $this->registerPolicies();

        // Livewire components
        $this->registerLivewireComponents();

        // Asset Registration
        FilamentAsset::register(
            $this->getAssets(),
            $this->getAssetPackageName()
        );

        FilamentAsset::registerScriptData(
            $this->getScriptData(),
            $this->getAssetPackageName()
        );

        // Icon Registration
        FilamentIcon::register($this->getIcons());

        // Handle Stubs
        if (app()->runningInConsole()) {
            foreach (app(Filesystem::class)->files(__DIR__ . '/../stubs/') as $file) {
                $this->publishes([
                    $file->getRealPath() => base_path("stubs/nested-comments/{$file->getFilename()}"),
                ], 'nested-comments-stubs');
            }
        }

        // Testing
        Testable::mixin(new TestsNestedComments);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'coolsam/nested-comments';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // AlpineComponent::make('nested-comments', __DIR__ . '/../resources/dist/components/nested-comments.js'),
            Css::make('nested-comments-styles', __DIR__ . '/../resources/dist/nested-comments.css'),
            Js::make('nested-comments-scripts', __DIR__ . '/../resources/dist/nested-comments.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            NestedCommentsCommand::class,
        ];
    }

    /**
     * @return array<string>
     */
    protected function getIcons(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getRoutes(): array
    {
        return [];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getScriptData(): array
    {
        return [];
    }

    /**
     * @return array<string>
     */
    protected function getMigrations(): array
    {
        return [
            'create_nested_comments_table',
        ];
    }

    protected function registerPolicies(): void
    {
        $policies = config('nested-comments.policies');

        // register policies
        foreach ($policies as $model => $policy) {
            if (! $policy) {
                continue;
            }
            $modelClass = config("nested-comments.models.{$model}");
            if (! $modelClass) {
                continue;
            }
            \Gate::policy($modelClass, $policy);
        }
    }

    protected function registerLivewireComponents()
    {
        $namespace = static::$viewNamespace;
        $components = $this->getLivewireComponents();
        if (empty($components)) {
            return;
        }
        foreach ($components as $name => $component) {
            Livewire::component("$namespace::$name", $component);
        }
    }

    protected function getLivewireComponents(): array
    {
        return [
            'comments' => Comments::class,
            'comment-card' => CommentCard::class,
            'add-comment' => AddComment::class,
        ];
    }
}
