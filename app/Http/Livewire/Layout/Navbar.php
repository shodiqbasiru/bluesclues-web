<?php

namespace App\Http\Livewire\Layout;

use App\Models\MerchCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{

    public $count = 0;
    public $products = [];

    protected $listeners = [
        'insertToCart' => 'updateCart'
    ];

    public function updateCart()
    {
        if (Auth::user()) {
            $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();
            if ($order) {
                $this->count = OrderDetail::where('order_id', $order->id)->count();
                $this->products = OrderDetail::where('order_id', $order->id)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            } else {
                $this->count = 0;
                $this->products = [];
            }
        }
    }

    public function mount()
    {
        if (Auth::user()) {
            $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();
            if ($order) {
                $this->count = OrderDetail::where('order_id', $order->id)->count();
                $this->products = OrderDetail::where('order_id', $order->id)
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();
            } else {
                $this->count = 0;
                $this->products = [];
            }
        }
    }

    public function render()
    {
        $category = MerchCategory::all();
        return view('livewire.layout.navbar', [
            'categories' => $category,
            'count_order' => $this->count,
            'productss' => $this->products,
        ]);
    }
}
