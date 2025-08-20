<?php

namespace Solutionforest\FontSizeSwitcher;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Illuminate\Support\Facades\View;

class FontSizeSwitcherPlugin implements Plugin
{
    protected array $fontSizes = [];

    protected string $defaultSize = 'md';

    protected bool $showInTopbar = true;

    protected string $position = 'left';

    public function getId(): string
    {
        return 'font-size-switcher';
    }

    public function register(Panel $panel): void
    {
        $panel->renderHook(
            'panels::global-search.before',
            fn (): string => $this->showInTopbar ? View::make('font-size-switcher::font-size-switcher', [
                'fontSizes' => $this->getFontSizes(),
                'defaultSize' => $this->defaultSize,
                'position' => $this->position,
            ])->render() : ''
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public function xs(float $scale): static
    {
        $this->fontSizes['xs'] = $scale;

        return $this;
    }

    public function sm(float $scale): static
    {
        $this->fontSizes['sm'] = $scale;

        return $this;
    }

    public function md(float $scale): static
    {
        $this->fontSizes['md'] = $scale;

        return $this;
    }

    public function lg(float $scale): static
    {
        $this->fontSizes['lg'] = $scale;

        return $this;
    }

    public function xl(float $scale): static
    {
        $this->fontSizes['xl'] = $scale;

        return $this;
    }

    public function defaultSize(string $size): static
    {
        $this->defaultSize = $size;

        return $this;
    }

    public function position(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function showInTopbar(bool $show = true): static
    {
        $this->showInTopbar = $show;

        return $this;
    }

    public function getFontSizes(): array
    {
        if (empty($this->fontSizes)) {
            return [
                'sm' => 0.875,
                'md' => 1.0,
                'lg' => 0.5,
            ];
        }

        return $this->fontSizes;
    }

    public static function make(): static
    {
        return new static;
    }

    public static function get(): static
    {
        return new static;
    }
}
