<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * The alert sidebar.
     *
     * @var string
     */
    public $sidebar;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($sidebar = 'open')
    {
        $this->sidebar = $sidebar;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.navbar');
    }
}
