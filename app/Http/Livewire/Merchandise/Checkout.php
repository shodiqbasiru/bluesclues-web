<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Validator;


class Checkout extends Component
{
    public $total_price, $name, $phone_number, $address, $postal_code, $notes;

    protected $rules = [
        'name' => 'required|min:2|max:50',
        'phone_number' => 'required|min:2|max:20',
        'address' => 'required',
        'postal_code' => 'required|min:2|max:20',
    ];

    public function mount()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }


        $this->name = Auth::user()->name;
        $this->phone_number = Auth::user()->phone_number;
        $this->address = Auth::user()->address;
        $this->postal_code = Auth::user()->postal_code;

        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();

        if (!empty($order)) {
            $this->total_price = $order->total_price;
        } else {
            return redirect()->route('store.index');
        }
    }

    public function checkout()
    {
        $this->validate();


        // update user profile
        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $this->name;
        $user->phone_number = $this->phone_number;
        $user->address = $this->address;
        $user->postal_code = $this->postal_code;
        $user->update();


        // update order status
        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();
        $order->notes = $this->notes;
        $order->status = 1;

        $order->update();

        // $this->emit('masukKeranjang');

        return redirect()->route('proof-upload', ['orderId' => $order->id]);
    }

    public function render()
    {
        return view('livewire.merchandise.checkout')->extends('layouts.merchandise.main');
    }
}
