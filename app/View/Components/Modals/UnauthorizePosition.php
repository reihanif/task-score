<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UnauthorizePosition extends Component
{
    /**
     * The modal position.
     *
     * @var string
     */
    public $position;

    /**
     * The modal department.
     *
     * @var string
     */
    public $department;

    /**
     * Create a new component instance.
     *
     * @param  string  $position
     * @param  string  $department
     * @return void
     */
    public function __construct($position, $department)
    {
        $this->position = $position;
        $this->department = $department;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.unauthorize-position');
    }
}
