<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{
    public string $variant;
    public string $size;

    public function __construct(string $variant = 'default', string $size = 'default')
    {
        $this->variant = $variant;
        $this->size = $size;
    }

    public function render()
    {
        return view('components.button');
    }
}
