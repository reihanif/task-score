<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class EditDepartment extends Component
{
    /**
     * The department parameter.
     *
     * @var string
     */
    public $department;

    /**
     * The positions parameter.
     *
     * @var string
     */
    public $positions;

    /**
     * Create a new component instance.
     *
     * @param  string  $department
     * @param  string  $positions
     * @return void
     */
    public function __construct($department, $positions)
    {
        $this->department = $department;
        $this->positions = $positions;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.edit-department');
    }
}
