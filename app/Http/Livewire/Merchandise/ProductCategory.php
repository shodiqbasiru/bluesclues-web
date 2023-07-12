<?php

namespace App\Http\Livewire\Merchandise;

use Livewire\Component;
use App\Models\Merchandise;
use App\Models\MerchCategory;
use Livewire\WithPagination;

class ProductCategory extends Component
{
    use WithPagination;

    public $search, $categoryId;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['search'];
    protected $listeners = ['selectCategory'];


    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function mount($categoryId)
    {
        $showCategory = MerchCategory::find($categoryId);
        if ($showCategory) {

            $this->categoryId = $categoryId;
        }
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



        return view('livewire.merchandise.product', [
            'products' => $products,
            'title' => $category->name,

        ])->extends('layouts.merchandise.main');
    }
}
