<?php

// config for Solutionforest/FontSizeSwitcher
return [
    /*
    |--------------------------------------------------------------------------
    | Font Size Switcher Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration options for the Font Size Switcher
    | plugin for Filament. You can customize the default behavior here.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Default Font Sizes
    |--------------------------------------------------------------------------
    |
    | These are the default font size options that will be available if you
    | don't specify custom sizes when registering the plugin.
    |
    */
    'default_font_sizes' => [
        'sm' => 0.875,  // Small (87.5%)
        'md' => 1.0,    // Medium (100% - default)
        'lg' => 1.125,  // Large (112.5%)
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Selected Size
    |--------------------------------------------------------------------------
    |
    | The default font size that will be selected when a user first visits
    | the application. This should match one of the keys in your font sizes.
    |
    */
    'default_size' => 'md',

    /*
    |--------------------------------------------------------------------------
    | Display Settings
    |--------------------------------------------------------------------------
    |
    | Configure where and how the font size switcher should be displayed.
    |
    */
    'display' => [
        'show_in_topbar' => true,
        'position' => 'right', // 'left' or 'right'
    ],

    /*
    |--------------------------------------------------------------------------
    | Storage Settings
    |--------------------------------------------------------------------------
    |
    | Configure how user preferences are stored.
    |
    */
    'storage' => [
        'key' => 'filament-font-size',
        'driver' => 'localStorage', // Currently only localStorage is supported
    ],

    /*
    |--------------------------------------------------------------------------
    | Styling
    |--------------------------------------------------------------------------
    |
    | CSS class prefix and other styling options.
    |
    */
    'styling' => [
        'class_prefix' => 'filament-font',
        'button_size' => '32px',
        'responsive_breakpoint' => '768px',
    ],
];
