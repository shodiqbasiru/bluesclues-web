<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class History extends Component
{
    public $orders;
    public $filterStatus;


    public function render()
    {
        if (Auth::user()) {
            $query = Order::where('user_id', Auth::user()->id)
                ->where('status', '!=', 0)
                ->with('loadOrderDetailsWithMerchandise')
                ->orderBy('created_at', 'desc');

            // Apply filter based on selected status
            if ($this->filterStatus) {
                $query->where('status', $this->filterStatus);
            }

            $this->orders = $query->get();
        }

        return view('livewire.merchandise.history')->extends('layouts.merchandise.main');
    }
}
