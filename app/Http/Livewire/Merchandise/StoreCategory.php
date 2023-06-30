<?php

namespace App\Http\Livewire\Merchandise;

use Livewire\Component;
use App\Models\Merchandise;
use App\Models\MerchCategory;
use Livewire\WithPagination;

class StoreCategory extends Component
{
    use WithPagination;

    public $search, $categoryId;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    public function render()
    {
        $category = MerchCategory::findOrFail($this->categoryId);

        if ($this->search) {
            $products = Merchandise::where('category_id', $this->categoryId)
                ->where('name', 'like', '%' . $this->search . '%')
                ->paginate(8);
        } else {
            $products = Merchandise::where('category_id', $this->categoryId)->paginate(8);
        }

        return view('livewire.merchandise.store', [
            'products' => $products,
            'title' => $category->name
        ])->extends('layouts.merchandise.main');
    }
}
