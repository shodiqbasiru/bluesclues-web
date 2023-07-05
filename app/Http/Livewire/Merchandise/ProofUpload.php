<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;


class ProofUpload extends Component
{
    use WithFileUploads;

    public $proof;
    public $orderId;

    public function mount($orderId)
    {
        $this->orderId = $orderId;

        $order = Order::where('user_id', Auth::user()->id)->where('id', $orderId)->first();

        if (!$order || $order->status > 2) {
            return redirect()->route('store.index');
        }
    }

    public function submit()
    {
        $this->validate([
            'proof' => 'required|image|max:7168', // Adjust the image validation rules as needed
        ]);

        $order = Order::find($this->orderId);

        if ($order) {
            // Delete the old proof image if it exists
            if ($order->proof) {
                Storage::delete($order->proof);
            }

            // Store the uploaded image and get its path
            $path = $this->proof->store('proofs-of-payment');

            // Update the proof field in the order with the new image path
            $order->proof = $path;
            $order->status = 2;
            $order->save();

            session()->flash('message', "Proof of payment uploaded successfully!");
        }

        return redirect()->route('history');
    }

    public function render()
    {
        return view('livewire.merchandise.proof-upload')->extends('layouts.merchandise.main');
    }
}
