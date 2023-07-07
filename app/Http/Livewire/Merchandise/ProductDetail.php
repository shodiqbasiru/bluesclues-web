<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use Livewire\Component;
use App\Models\Merchandise;
use App\Models\OrderDetail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class ProductDetail extends Component
{
    use AuthorizesRequests;

    public $product, $quantity = 1, $randomItems;

    public function mount($slug)
    {
        $otherProducts = Merchandise::inRandomOrder()->limit(3)->get();
        $this->randomItems = $otherProducts;

        $productDetail = Merchandise::where('slug', $slug)->firstOrFail();
        if ($productDetail) {

            $this->product = $productDetail;
        }
    }

    public function addToCart()
    {
        if (Auth::guard('admin')->check()) {
            // Redirect the admin to a different page or show an error message
            return redirect()->route('admin.dashboard'); // Replace 'admin.dashboard' with the desired admin page
        }

        if (Auth::guest()) {
            return redirect()->route('login');
        }

        if (!Auth::user()->email_verified_at) {
            return redirect()->route('verification.notice');
        }

        // Validate
        $validatedData = $this->validate([
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $validatedData['quantity'];
        $total_price = $quantity * $this->product->price;

        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // Check if order exists
        if ($order) {
            $orderDetail = $order->orderDetails()->where('merchandise_id', $this->product->id)->first();
            if ($orderDetail) {
                if ($orderDetail->quantity + $quantity > 10) {
                    return redirect()->back()->with('error', 'The product could not be added, the maximum number of product is 10.');
                }
                // Update the quantity and total price of the existing orderDetail
                $orderDetail->update([
                    'quantity' => $orderDetail->quantity + $quantity,
                    'total_price' => $orderDetail->total_price + $total_price,
                ]);
            } else {
                // Create a new orderDetail entry
                OrderDetail::create([
                    'order_id' => $order->id,
                    'merchandise_id' => $this->product->id,
                    'quantity' => $quantity,
                    'total_price' => $total_price,
                ]);
            }

            // Update the total price of the order
            $order->update([
                'total_price' => $order->total_price + $total_price,
            ]);
        } else {
            // Create a new order
            $order = Order::create([
                'user_id' => Auth::user()->id,
                'total_price' => $total_price,
                'status' => 0,
            ]);
            $order->order_number = 'BLS-' . $order->id;
            $order->save();

            // Create a new orderDetail entry
            OrderDetail::create([
                'order_id' => $order->id,
                'merchandise_id' => $this->product->id,
                'quantity' => $quantity,
                'total_price' => $total_price,
            ]);
        }
        $this->quantity = 1;
        $this->emit('insertToCart');
        return redirect()->back()->with('success', 'Product added to cart');
    }

    public function incrementQuantity()
    {
        if ($this->quantity < 10) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }


    public function render()
    {
        return view('livewire.merchandise.product-detail', [
            'title' => 'Product Detail',
            'quantity' => $this->quantity,
            'products' => $this->randomItems,

        ])->extends('layouts.merchandise.main');
    }
}
