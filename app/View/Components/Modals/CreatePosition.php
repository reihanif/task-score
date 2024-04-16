<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CreatePosition extends Component
{
    /**
     * The modal positions.
     *
     * @var
     */
    public $positions;

    /**
     * Create a new component instance.
     */
    public function __construct($positions)
    {
        $this->positions = $positions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.create-position');
    }
}
