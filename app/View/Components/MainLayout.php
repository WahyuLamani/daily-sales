<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MainLayout extends Component
{
    public $resources = ['resources/sass/app.scss', 'resources/css/app.css', 'resources/js/app.js'];
    public $title;
    public function __construct($resources, $title)
    {
        $resources = explode(',', $resources);
        $this->resources = array_merge($this->resources, $resources);
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {

        return view('components.main-layout');
    }
}
