<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CardDashboard extends Component
{
    public $value;
    public $key;
    public function __construct($value, $key)
    {
        $this->value = $value;
        $this->key = $key;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.card-dashboard');
    }
}
