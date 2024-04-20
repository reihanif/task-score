<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarExpandedMenu extends Component
{
    /**
     * The sidebar menus.
     *
     * @var array
     */
    public $menus;

    /**
     * The sidebar routes.
     *
     * @var array
     */
    public $routes;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menu = [])
    {
        // dd(collect($menu)->pluck('data-route-name')->toArray());
        $this->routes = collect($menu)->pluck('data-route-name');
        $this->menus = $menu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-expanded-menu');
    }
}
