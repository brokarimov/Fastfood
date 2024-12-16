<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Component;

class QueuesComponent extends Component
{
    public $orders1;
    public $orders2;
    public $orders3;
    public $orders4;
    public function mount()
    {
        $this->orders1 = Order::where('status', 1)->get();
        $this->orders2 = Order::where('status', 2)->get();
        $this->orders3 = Order::where('status', 3)->get();
        $this->orders4 = Order::where('status', 4)->get();

    }
    public function render()
    {
        return view('livewire.queues-component')->layout('components.layouts.user');
    }
}
