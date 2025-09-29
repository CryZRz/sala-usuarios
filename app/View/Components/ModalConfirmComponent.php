<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ModalConfirmComponent extends Component
{
    public string $id;
    public string $message;
    public function __construct(string $id, string $message)
    {
        $this->id = $id;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modal-confirm-component');
    }
}
