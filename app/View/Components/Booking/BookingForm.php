<?php

namespace App\View\Components\Booking;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class BookingForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.booking.booking-form');
    }
}
