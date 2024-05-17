<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public $modalId;
    public $title;
    public function __construct($modalId,$title)
    {
        $this->modalId = $modalId;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal');
    }
}
