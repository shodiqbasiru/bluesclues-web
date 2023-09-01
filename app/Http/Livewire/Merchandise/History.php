<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class History extends Component
{
    public $orders;
    public $filterStatus;

    protected $listeners = ['orderCanceled'];


    public function render()
    {
        if (Auth::user()) {
            $query = Order::where('user_id', Auth::user()->id)
                ->where('status', '!=', 0)
                ->with('loadOrderDetailsWithMerchandise')
                ->orderBy('created_at', 'desc');

            // Apply filter based on selected status
            if ($this->filterStatus) {
                $query->where('status', $this->filterStatus);
            }

            $this->orders = $query->get();
        }

        $labels = [
            '' => 'All Orders',
            '1' => 'Waiting for Payment',
            '2' => 'Checking Payment',
            '3' => 'Payment Success',
            '4' => 'Cancelled',
            '5' => 'Shipping',
            '6' => 'Product Received',
        ];

        $statusLabel = $labels[$this->filterStatus] ?? 'Filter Status';

        return view('livewire.merchandise.history', [
            'orders' => $this->orders,
            'statusLabel' => $statusLabel,
        ])->extends('layouts.merchandise.main');
    }

    public function setFilterStatus($status)
    {
        $this->filterStatus = $status;
    }

    public function mount()
    {
        $this->filterStatus = '';
    }


    public function cancelOrder($orderId)
    {
        $order = Order::with('orderDetails.merchandise')->find($orderId);

        if ($order) {
            $order->status = 4; // Set status to "canceled"
            $order->save();

            $this->increaseStockAfterCancel($order); // Increase stock after canceling order
            session()->flash('message', 'Order canceled successfully.');

            $this->emit('orderCanceled'); // Emit the "orderCanceled" event
        } else {
            session()->flash('message', 'Order not found.');
        }
    }

    protected function increaseStockAfterCancel($order)
    {
        // Array to store product data for bulk update
        $productData = [];

        foreach ($order->orderDetails as $orderDetail) {
            $merchandise = $orderDetail->merchandise;
            $newStock = $merchandise->stock + $orderDetail->quantity;

            // Prepare data for bulk update
            $productData[] = [
                'id' => $merchandise->id,
                'stock' => max(0, $newStock),
                'is_available' => $newStock > 0 ? 1 : 0,
            ];
        }

        // Extract the IDs to update
        $idsToUpdate = collect($productData)->pluck('id');

        // Use a single bulk update query
        \DB::table('merchandises')
            ->whereIn('id', $idsToUpdate)
            ->update(['stock' => \DB::raw('CASE id ' . implode(' ', array_map(function ($data) {
                return 'WHEN ' . $data['id'] . ' THEN ' . $data['stock'];
            }, $productData)) . ' END'), 'is_available' => \DB::raw('CASE id ' . implode(' ', array_map(function ($data) {
                return 'WHEN ' . $data['id'] . ' THEN ' . $data['is_available'];
            }, $productData)) . ' END'),
            'updated_at' => now(),
        ]);
    }

    public function orderCanceled()
    {
        // Method ini tidak perlu melakukan apa pun, karena hanya digunakan sebagai listener event
    }


    public function receiveOrder($orderId)
    {
        $order = Order::find($orderId);

        if ($order) {
            $order->status = 6; // Set status to "Product Received"
            $order->save();
            session()->flash('message', 'Order received successfully.');

            $this->emit('orderReceived'); // Emit the "orderReceived" event
        } else {
            session()->flash('message', 'Order not found.');
        }
    }
}
