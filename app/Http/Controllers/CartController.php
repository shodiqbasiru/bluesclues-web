<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchandise;
use App\Models\MerchCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $cart = Order::with('orderDetails.merchandise')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->get();


        return view('merchandise.cart', [
            'cart' => $cart,
        ]);
    }

    public function addToCart(Request $request)
    {
        // Validate
        $validatedData = $request->validate([
            'quantity-select' => 'required|integer|min:1|max:10',
        ]);

        $quantity = $validatedData['quantity-select'];
        $total_price = $quantity * $request->price;

        $order = Order::where('user_id', Auth::user()->id)->where('status', 0)->first();

        // Check if order exists
        if ($order) {
            $orderDetail = $order->orderDetails()->where('merchandise_id', $request->merchandise_id)->first();

            if ($orderDetail) {
                // Update the quantity and total price of the existing orderDetail
                $orderDetail->update([
                    'quantity' => $orderDetail->quantity + $quantity,
                    'total_price' => $orderDetail->total_price + $total_price,
                ]);
            } else {
                // Create a new orderDetail entry
                OrderDetail::create([
                    'order_id' => $order->id,
                    'merchandise_id' => $request->merchandise_id,
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
            $order->order_number = 'ORD-' . $order->id;
            $order->save();

            // Create a new orderDetail entry
            OrderDetail::create([
                'order_id' => $order->id,
                'merchandise_id' => $request->merchandise_id,
                'quantity' => $quantity,
                'total_price' => $total_price,
            ]);
        }

        return redirect()->back()->with('success', 'Item added to cart successfully');
    }

    public function destroy(OrderDetail $orderDetail)
    {
        if ($orderDetail->order->user_id !== auth()->user()->id) {
            abort(403); // Unauthorized access
        }

        $order = $orderDetail->order;

        // Calculate the amount to be decreased from the total price
        $decreaseAmount = $orderDetail->total_price;

        // Delete the order detail
        $orderDetail->delete();

        // Update the total price in the order
        $order->total_price -= $decreaseAmount;
        $order->save();

        // Check if the order has no remaining order details
        if ($order->orderDetails->isEmpty()) {
            // Delete the order
            $order->delete();
        }

        return redirect()->back();
    }

    public function increaseQuantity(OrderDetail $orderDetail)
    {
        $order = $orderDetail->order;
        $merchandisePrice = $orderDetail->merchandise->price;

        // Update the order detail and order in memory
        $orderDetail->quantity++;
        $orderDetail->total_price += $merchandisePrice;
        $order->total_price += $merchandisePrice;

        // Save the changes in a single update query
        $orderDetail->save();
        $order->save();

        return redirect()->back();
    }

    public function decreaseQuantity(OrderDetail $orderDetail)
    {
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
        }

        return redirect()->back();
    }
}
