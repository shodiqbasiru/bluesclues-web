<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Validator;


class Checkout extends Component
{
    public $total_price, $name, $phone_number, $address, $postal_code, $notes, $order;
    public $total_quantity = 0;

    protected $rules = [
        'name' => 'required|min:2|max:50',
        'phone_number' => 'required|min:2|max:20',
        'address' => 'required',
        'postal_code' => 'required|min:2|max:8',
    ];

    public function mount()
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        } else {
            $this->order = Order::with('orderDetails.merchandise')
                ->where('user_id', Auth::user()->id)
                ->where('status', 0)
                ->get();
        }

        $this->total_quantity = 0;

        foreach ($this->order as $order) {
            foreach ($order->orderDetails as $orderDetail) {
                $this->total_quantity += $orderDetail->quantity;
            }
        }


        $this->name = Auth::user()->name;
        $this->phone_number = Auth::user()->phone_number;
        $this->address = Auth::user()->address;
        $this->postal_code = Auth::user()->postal_code;

        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();

        if (!empty($order)) {
            $this->total_price = $order->total_price;
        } else {
            return redirect()->route('merchandise.home');
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
        $order->name = $this->name;
        $order->phone_number = $this->phone_number;
        $order->address = $this->address;
        $order->postal_code = $this->postal_code;
        $order->status = 1;

        $order_to_email = Order::with('orderDetails.merchandise')
            ->where('id', $order->id)
            ->get();

        $messageData = [
            'name' => $order->name,
            'email' => $user->email,
            'phone_number' => $order->phone_number,
            'address' => $order->address,
            'postal_code' => $order->postal_code,
            'order' => $order_to_email,
        ];

        $emailController = new EmailController();
        $emailController->newOrderNotificationEmail($messageData);

        $order->update();

        // $this->emit('masukKeranjang');

        return redirect()->route('proof-upload', ['orderId' => $order->id]);
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

        return view('livewire.merchandise.checkout', [
            'orders' => $this->order,
            'order_details' => $orderDetails,
        ])->extends('layouts.merchandise.main');
    }
}
