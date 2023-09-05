<?php

namespace App\Http\Livewire\Layout;

use App\Models\MerchCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Http\Livewire\Merchandise\Cart;



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
                    ->with('merchandise')
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
                    ->with('merchandise')
                    ->orderBy('created_at', 'desc')
                    ->take(3)
                    ->get();

                $orderDetails = OrderDetail::where('order_id', $order->id)
                    ->with('merchandise')
                    ->get();

                foreach ($orderDetails as $orderDetail) {
                    if (!$orderDetail->merchandise) {
                        $this->destroyIfNotExist($orderDetail->id);
                    }
                }
            } else {
                $this->count = 0;
                $this->products = [];
            }

        }
    }

    public function destroyIfNotExist($id)
    {
        $orderDetail = OrderDetail::find($id);
        if (!empty($orderDetail)) {
            $order = Order::where('id', $orderDetail->order_id)->first();
            $totalOrder = OrderDetail::where('order_id', $order->id)->count();
            if ($totalOrder == 1) {
                $order->delete();
            } else {
                $order->total_price =  $order->total_price - $orderDetail->total_price;
                $order->total_weight =  $order->total_weight - $orderDetail->total_weight;
                $order->save();
            }

            $orderDetail->delete();
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
