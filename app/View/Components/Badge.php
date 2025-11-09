<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Badge extends Component
{
    public string $variant;

    public function __construct(string $variant = 'default')
    {
        $this->variant = $variant;
    }

    public function render()
    {
        return view('components.badge');
    }
}
