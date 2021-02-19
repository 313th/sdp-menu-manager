<?php


namespace sahifedp\MenuManager\Views\Components\Show;

use Illuminate\View\Component;
use sahifedp\MenuManager\MenuManager;

class Show extends Component
{

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        $menus = MenuManager::myMenu();
        return view('menu::components.Show.show',['menus'=>$menus]);
    }
}
