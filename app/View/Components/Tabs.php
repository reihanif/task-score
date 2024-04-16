<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Tabs extends Component
{
    /**
     * The tabs menu.
     *
     * @var array
     */
    public $tabs;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($tabs = [])
    {
        $this->tabs = $tabs;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.tabs');
    }
}
