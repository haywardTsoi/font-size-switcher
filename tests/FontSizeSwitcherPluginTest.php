<?php

use Solutionforest\FontSizeSwitcher\FontSizeSwitcherPlugin;

test('font size switcher plugin can be instantiated', function () {
    $plugin = FontSizeSwitcherPlugin::make();

    expect($plugin)->toBeInstanceOf(FontSizeSwitcherPlugin::class);
    expect($plugin->getId())->toBe('font-size-switcher');
});

test('font size switcher plugin can set font sizes', function () {
    $plugin = FontSizeSwitcherPlugin::make()
        ->small(0.8)
        ->normal(1.0)
        ->large(1.2);

    $fontSizes = $plugin->getFontSizes();

    expect($fontSizes)->toHaveKey('small', 0.8)
        ->toHaveKey('normal', 1.0)
        ->toHaveKey('large', 1.2);
});

test('font size switcher plugin has default font sizes when none set', function () {
    $plugin = FontSizeSwitcherPlugin::make();

    $fontSizes = $plugin->getFontSizes();

    expect($fontSizes)->toHaveKey('small', 0.8)
        ->toHaveKey('normal', 1.0)
        ->toHaveKey('large', 1.2);
});

test('font size switcher plugin can set default size', function () {
    $plugin = FontSizeSwitcherPlugin::make()
        ->small(0.8)
        ->normal(1.0)
        ->large(1.2)
        ->defaultSize('large');

    expect($plugin->getDefaultSize())->toBe('large');
});
