<?php

namespace Solutionforest\FontSizeSwitcher;

use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Solutionforest\FontSizeSwitcher\Commands\FontSizeSwitcherCommand;
use Solutionforest\FontSizeSwitcher\Testing\TestsFontSizeSwitcher;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FontSizeSwitcherServiceProvider extends PackageServiceProvider
{
    public static string $name = 'font-size-switcher';

    public static string $viewNamespace = 'font-size-switcher';

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
                    ->askToStarRepoOnGitHub('solutionforest/font-size-switcher');
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
    }

    public function packageRegistered(): void
    {
        // 註冊默認配置
        app()->instance('font-size-switcher.config', [
            'fontSizes' => ['small' => 0.8, 'normal' => 1.0, 'large' => 1.2],
            'defaultSize' => 'normal',
        ]);
    }

    public function packageBooted(): void
    {
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
                    $file->getRealPath() => base_path("stubs/font-size-switcher/{$file->getFilename()}"),
                ], 'font-size-switcher-stubs');
            }
        }

        // 發布 assets
        $this->publishes([
            __DIR__ . '/../resources/css' => public_path('vendor/font-size-switcher/css'),
            __DIR__ . '/../resources/js' => public_path('vendor/font-size-switcher/js'),
        ], 'font-size-switcher-assets');

        // 註冊 render hook
        \Filament\Facades\Filament::serving(function () {
            \Filament\Facades\Filament::registerRenderHook(
                \Filament\View\PanelsRenderHook::GLOBAL_SEARCH_BEFORE,
                fn (): string => $this->renderFontSizeControl()
            );
        });

        // Testing
        Testable::mixin(new TestsFontSizeSwitcher);
    }

    private function renderFontSizeControl(): string
    {
        $config = app('font-size-switcher.config');

        return \Illuminate\Support\Facades\Blade::render('font-size-switcher::font-size-control', [
            'fontSizes' => $config['fontSizes'],
            'defaultSize' => $config['defaultSize'],
        ]);
    }

    protected function getAssetPackageName(): ?string
    {
        return 'solutionforest/font-size-switcher';
    }

    /**
     * @return array<Asset>
     */
    protected function getAssets(): array
    {
        return [
            // Css::make('font-size-switcher-styles', __DIR__ . '/../resources/css/font-size-switcher.css'),
            // Js::make('font-size-switcher-scripts', __DIR__ . '/../resources/js/font-size-switcher.js'),
        ];
    }

    /**
     * @return array<class-string>
     */
    protected function getCommands(): array
    {
        return [
            FontSizeSwitcherCommand::class,
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
            'create_font-size-switcher_table',
        ];
    }
}
