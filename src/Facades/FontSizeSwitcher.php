<?php

namespace Solutionforest\FontSizeSwitcher\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Solutionforest\FontSizeSwitcher\FontSizeSwitcher
 */
class FontSizeSwitcher extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Solutionforest\FontSizeSwitcher\FontSizeSwitcher::class;
    }
}
