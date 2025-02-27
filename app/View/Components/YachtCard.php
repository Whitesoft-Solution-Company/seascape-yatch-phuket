<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class YachtCard extends Component
{
    public $image;
    public $nameboat;
    public $description;
    public $max;
    public $price;
    public $packageid;
    public $date;
    public $datereturn;

    public function __construct($image, $nameboat, $description, $max, $price , $packageid,$date,$datereturn)
    {
        $this->image = $image;
        $this->nameboat = $nameboat;
        $this->description = $description;
        $this->max = $max;
        $this->price = $price;
        $this->packageid = $packageid;
        $this->date = $date;
        $this->datereturn = $datereturn;

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.yacht-card');
    }
}
