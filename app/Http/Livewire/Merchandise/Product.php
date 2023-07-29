<?php

namespace App\Http\Livewire\Merchandise;

use Livewire\Component;
use App\Models\Merchandise;
use Livewire\WithPagination;
use App\Models\MerchCategory;

class Product extends Component
{

    use WithPagination;
    public  $search;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }



    public function render()
    {
        // $categories = MerchCategory::all();

        if ($this->search) {
            $products = Merchandise::where('name', 'like', '%' . $this->search . '%')->paginate(8);
        } else {

            $products = Merchandise::paginate(8);
        }

        return view('livewire.merchandise.product', [
            'title' => 'All Prodcuts',
            'products' => $products,
            // 'categories' => $categories,

        ])->extends('layouts.merchandise.main');
    }
}
