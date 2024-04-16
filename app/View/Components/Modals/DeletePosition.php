<?php

namespace App\View\Components\Modals;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DeletePosition extends Component
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
     */
    public function render(): View|Closure|string
    {
        return view('components.modals.delete-position');
    }
}
