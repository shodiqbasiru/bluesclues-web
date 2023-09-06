<?php

namespace App\Http\Livewire\Merchandise;

use Livewire\Component;
use App\Models\Merchandise;

class Store extends Component
{

    public function render()
    {
        $products = Merchandise::where('is_available', 1)
            ->take(4)
            ->orderby('created_at', 'desc')
            ->get();

        return view('livewire.merchandise.store', [
            'title' => 'Products Recommendation',
            'products' => $products,

        ])->extends('layouts.merchandise.main');
    }
}
