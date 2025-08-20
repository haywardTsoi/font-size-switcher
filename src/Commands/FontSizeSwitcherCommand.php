<?php

namespace Solutionforest\FontSizeSwitcher\Commands;

use Illuminate\Console\Command;

class FontSizeSwitcherCommand extends Command
{
    public $signature = 'font-size-switcher';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
