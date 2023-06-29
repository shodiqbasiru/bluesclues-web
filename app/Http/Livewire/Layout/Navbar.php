<?php

namespace App\Http\Livewire\Layout;

use App\Models\MerchCategory;
use Livewire\Component;

class Navbar extends Component
{
    public function render()
    {
        $category = MerchCategory::all();
        return view('livewire.layout.navbar', [
            'categories' => $category,
        ]);
    }
}
