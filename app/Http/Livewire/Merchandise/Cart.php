<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Cart extends Component
{
    // public $order;
    public $order, $quantity = [];

    protected $listeners = ['updatedQuantity'];

    public function updatedQuantity($orderDetailId)
    {
        $this->order = null; // Clear the cache for the $order variable
        $this->mount();
    }

    public function mount()
    {

        if (Auth::user()) {
            $this->order = Order::with('orderDetails.merchandise')
                ->where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->get();
            if ($this->order) {
                foreach ($this->order as $order) {
                    foreach ($order->orderDetails as $orderDetail) {
                        $this->quantity[$orderDetail->id] = $orderDetail->quantity;
                    }
                }
            }
        }
    }

    public function incrementQuantity($orderDetailId)
    {

        $orderDetail = OrderDetail::find($orderDetailId);
        if ($orderDetail->quantity < 10) {

            $order = $orderDetail->order;
            $merchandisePrice = $orderDetail->merchandise->price;

            // Update the order detail and order in memory
            $orderDetail->quantity++;
            $orderDetail->total_price += $merchandisePrice;
            $order->total_price += $merchandisePrice;

            // Save the changes in a single update query
            $orderDetail->save();
            $order->save();
        }

        $this->emitUp('updatedQuantity', $orderDetailId);
        $this->order = null; // Clear the cache for the $order variable
        $this->mount();
    }

    public function decrementQuantity($orderDetailId)
    {
        $orderDetail = OrderDetail::find($orderDetailId);
        if ($orderDetail->quantity > 1) {
            $order = $orderDetail->order;
            $merchandisePrice = $orderDetail->merchandise->price;

            // Update the order detail and order in memory
            $orderDetail->quantity--;
            $orderDetail->total_price -= $merchandisePrice;
            $order->total_price -= $merchandisePrice;

            // Save the changes in a single update query
            $orderDetail->save();
            $order->save();
        } else {
            $this->destroy($orderDetailId);
        }

        $this->emitUp('updatedQuantity', $orderDetailId);
        $this->order = null; // Clear the cache for the $order variable
        $this->mount();
    }

    public function destroy($id)
    {
        $orderDetail = OrderDetail::find($id);
        if (!empty($orderDetail)) {
            $order = Order::where('id', $orderDetail->order_id)->first();
            $totalOrder = OrderDetail::where('order_id', $order->id)->count();
            if ($totalOrder == 1) {
                $order->delete();
            } else {
                $order->total_price =  $order->total_price - $orderDetail->total_price;
                $order->save();
            }

            $orderDetail->delete();
        }

        $this->order = null; // Clear the cache for the $order variable
        $this->mount(); // Re-mount the component to fetch fresh data from the database

        $this->emit('insertToCart');

        session()->flash('message', 'Order has been deleted');
    }


    public function render()
    {

        $orderDetails = [];
        if (Auth::user()) {
            if ($this->order) {
                foreach ($this->order as $order) {
                    foreach ($order->orderDetails as $orderDetail) {
                        $orderDetails[] = $orderDetail;
                    }
                }
            }
        } else {
            $orderDetails = [];
        }
        // dd($orderDetails);

        return view('livewire.merchandise.cart', [
            'title' => 'Cart Page',
            'order' => $this->order,
            'order_details' => $orderDetails,
        ])->extends('layouts.merchandise.main');
    }
}
