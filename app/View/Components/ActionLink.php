<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ActionLink extends Component
{
    public string $can;
    public string $href;
    public string $style;

    /**
     * Create a new component instance.
     */
    public function __construct(string $can, string $href, string $style)
    {
        $this->can = $can;
        $this->href = $href;
        $this->style = $style;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action-link');
    }
}
