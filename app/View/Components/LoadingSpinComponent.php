<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class LoadingSpinComponent extends Component
{
    public ?string $styles;
    public function __construct(string $styles = null)
    {
        $this->styles = $styles;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.loading-spin-component');
    }
}
