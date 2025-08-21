<?php

namespace Solutionforest\FontSizeSwitcher;

use Filament\Contracts\Plugin;
use Filament\Panel;

class FontSizeSwitcherPlugin implements Plugin
{
    protected array $fontSizes = [];

    protected string $defaultSize = 'normal';

    public function getId(): string
    {
        return 'font-size-switcher';
    }

    public static function make(): static
    {
        return new static;
    }

    public function small(float $multiplier): static
    {
        $this->fontSizes['small'] = $multiplier;

        return $this;
    }

    public function normal(float $multiplier): static
    {
        $this->fontSizes['normal'] = $multiplier;
        $this->defaultSize = 'normal';

        return $this;
    }

    public function large(float $multiplier): static
    {
        $this->fontSizes['large'] = $multiplier;

        return $this;
    }

    public function defaultSize(string $size): static
    {
        $this->defaultSize = $size;

        return $this;
    }

    public function getFontSizes(): array
    {
        if (empty($this->fontSizes)) {
            return [
                'small' => 0.8,
                'normal' => 1.0,
                'large' => 1.2,
            ];
        }

        return $this->fontSizes;
    }

    public function getDefaultSize(): string
    {
        return $this->defaultSize;
    }

    public function register(Panel $panel): void
    {
        // 將配置數據存儲到容器中，供 ServiceProvider 使用
        app()->instance('font-size-switcher.config', [
            'fontSizes' => $this->getFontSizes(),
            'defaultSize' => $this->defaultSize,
        ]);
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function get(): static
    {
        return new static;
    }
}
