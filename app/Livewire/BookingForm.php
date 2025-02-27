<?php

namespace App\Livewire;

use Livewire\Component;

class BookingForm extends Component
{
    public $packageId;
    public $guestName;
    public $bookingDate;

    protected $rules = [
        'guestName' => 'required|string|max:255',
        'bookingDate' => 'required|date',
    ];

 

    public function render()
    {
        return view('livewire.booking-form');
    }
}
