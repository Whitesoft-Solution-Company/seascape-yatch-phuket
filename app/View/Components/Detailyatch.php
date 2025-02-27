<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Package;
use Illuminate\Support\Facades\DB;

class Detailyatch extends Component
{
   public $package;
   public $duration;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->package = Package::with(['packageType', 'prices'])
            ->where('status',1)
            ->get();
        $this->duration = Package::select('start_time', DB::raw('MAX(id) as id'))
            ->where('status', 1)
            ->groupBy('start_time')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.detailyatch');
    }
}
