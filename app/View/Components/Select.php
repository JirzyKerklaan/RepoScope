<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public string $name;
    public $options;
    public $selected;

    /**
     * Create a new component instance.
     *
     * @param string $name
     * @param array $options
     * @param string|null $selected
     */
    public function __construct(string $name, array $options = [], $selected = null)
    {
        $this->name = $name;
        $this->options = $options;
        $this->selected = $selected;
    }

    public function render()
    {
        return view('components.select');
    }
}
