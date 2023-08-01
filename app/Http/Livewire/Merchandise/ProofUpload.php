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


    protected $rules = [
        'proof' => 'required|image|mimes:jpeg,png|max:5124',
    ];

    protected $messages = [
        'proof.required' => 'The image field is required.',
        'proof.image' => 'The file must be an image.',
        'proof.mimes' => 'The image must be a file of type: jpeg, png.',
        'proof.max' => 'The image may not be greater than 5124 max kilobytes.',
    ];

    public function mount($orderId)
    {
        $this->orderId = $orderId;

        $order = Order::where('user_id', Auth::user()->id)->where('id', $orderId)->first();

        if (!$order || $order->status > 2 || $order->status == 0) {
            return redirect()->route('merchandise.home');
        }
    }

    public function submit()
    {
        $this->validate();

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
        $order = Order::where('user_id', Auth::user()->id)->where('id', $this->orderId)->first();
        return view('livewire.merchandise.proof-upload', [
            'preview' => $this->proof ? $this->proof->temporaryUrl() : null,
            'order' => $order
        ])->extends('layouts.merchandise.main');
    }
}
