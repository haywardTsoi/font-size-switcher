<?php

namespace App\View\Components;

use Illuminate\View\Component;

class FontSizeControl extends Component
{
    public array $fontSizes;

    public string $defaultSize;

    public function __construct(
        array $fontSizes = ['small' => 0.8, 'normal' => 1.0, 'large' => 1.2],
        string $defaultSize = 'normal'
    ) {
        $this->fontSizes = $fontSizes;
        $this->defaultSize = $defaultSize;
    }

    public function render()
    {
        return view('components.font-size-control');
    }
}
