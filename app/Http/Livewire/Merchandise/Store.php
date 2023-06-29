<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Merchandise;
use Livewire\Component;
use Livewire\WithPagination;

class Store extends Component
{

    use WithPagination;

    public $search;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if ($this->search) {
            $products = Merchandise::where('name', 'like', '%' . $this->search . '%')->paginate(8);
        } else {

            $products = Merchandise::paginate(8);
        }
        return view('livewire.merchandise.store', [
            'products' => $products,
        ]);
        // ->extends('layouts.merchandise.main');
        // return view('livewire.merchandise.store')->extends('layouts.merchandise.main', [
        //     'products' => $products,
        // ]);
    }
}
