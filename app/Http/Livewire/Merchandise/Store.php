<?php

namespace App\Http\Livewire\Merchandise;

use Livewire\Component;
use App\Models\Merchandise;

class Store extends Component
{

    public function render()
    {
        $products = Merchandise::take(4)->get();


        return view('livewire.merchandise.store', [
            'title' => 'Products Recommendation',
            'products' => $products,

        ])->extends('layouts.merchandise.main');
    }
}
