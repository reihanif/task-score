<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PositionAuthorization extends Component
{
    /**
     * The modal position.
     *
     * @var string
     */
    public $position;

    /**
     * The modal departments.
     *
     * @var string
     */
    public $departments;

    /**
     * Create a new component instance.
     *
     * @param  string  $position
     * @param  string  $departments
     * @return void
     */
    public function __construct($position, $departments)
    {
        $this->position = $position;
        $this->departments = $departments;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.position-authorization');
    }
}
