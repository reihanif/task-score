<?php

namespace App\View\Components\Modals;

use Illuminate\View\Component;

class DeleteDepartment extends Component
{
    /**
     * The modal id.
     *
     * @var string
     */
    public $id;

    /**
     * The modal name.
     *
     * @var string
     */
    public $name;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  string  $name
     * @return void
     */
    public function __construct($id, $name)
    {
        $this->id = $id;
        $this->name = htmlspecialchars_decode($name);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modals.delete-department');
    }
}
