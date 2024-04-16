<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class EditPosition extends Component
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
     * The modal position.
     *
     * @var
     */
    public $current_position;

    /**
     * The modal positions.
     *
     * @var
     */
    public $positions;

    /**
     * Create a new component instance.
     *
     * @param  string  $id
     * @param  string  $name
     * @param  string  $current_position_id
     * @param  string  $positions
     * @return void
     */
    public function __construct($id, $name, $position, $positions)
    {
        $this->id = $id;
        $this->name = htmlspecialchars_decode($name);
        $this->current_position = $position;
        $this->positions = $positions;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.edit-position');
    }
}
