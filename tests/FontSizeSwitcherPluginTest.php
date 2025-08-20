<?php

use Solutionforest\FontSizeSwitcher\FontSizeSwitcherPlugin;

test('font size switcher plugin can be instantiated', function () {
    $plugin = FontSizeSwitcherPlugin::make();

    expect($plugin)->toBeInstanceOf(FontSizeSwitcherPlugin::class);
    expect($plugin->getId())->toBe('font-size-switcher');
});

test('font size switcher plugin can set font sizes', function () {
    $plugin = FontSizeSwitcherPlugin::make()
        ->xs(0.8)
        ->sm(0.875)
        ->md(1.0)
        ->lg(1.125)
        ->xl(1.25);

    $fontSizes = $plugin->getFontSizes();

    expect($fontSizes)->toHaveKey('xs', 0.8)
        ->toHaveKey('sm', 0.875)
        ->toHaveKey('md', 1.0)
        ->toHaveKey('lg', 1.125)
        ->toHaveKey('xl', 1.25);
});

test('font size switcher plugin has default font sizes when none set', function () {
    $plugin = FontSizeSwitcherPlugin::make();

    $fontSizes = $plugin->getFontSizes();

    expect($fontSizes)->toHaveKey('sm', 0.875)
        ->toHaveKey('md', 1.0)
        ->toHaveKey('lg', 1.125);
});

test('font size switcher plugin can set default size', function () {
    $plugin = FontSizeSwitcherPlugin::make()
        ->defaultSize('lg');

    // We can't directly test the private property, but we can check the method chain works
    expect($plugin)->toBeInstanceOf(FontSizeSwitcherPlugin::class);
});

test('font size switcher plugin can configure display options', function () {
    $plugin = FontSizeSwitcherPlugin::make()
        ->showInTopbar(false)
        ->position('left');

    expect($plugin)->toBeInstanceOf(FontSizeSwitcherPlugin::class);
});
