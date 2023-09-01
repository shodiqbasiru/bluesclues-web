<?php

namespace App\Http\Livewire\Merchandise;

use App\Models\Order;
use App\Models\User;

use App\Models\Province;
use App\Models\City;
use App\Models\Courier;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Validator;
use Kavist\RajaOngkir\Facades\RajaOngkir;


class Checkout extends Component
{
    public $total_price, $name, $phone_number, $address, $postal_code, $notes, $order, $province_dest, $city_dest, $courier, $service, $cost, $total_cost, $user, $total_weight, $displayed_weight;
    public $total_quantity = 0;
    public $cities = [];
    public $shippingAvailable = true;

    protected $rules = [
        'name' => 'required|min:2|max:50',
        'phone_number' => 'required|min:2|max:20',
        'address' => 'required',
        'postal_code' => 'required|min:2|max:8',
        'province_dest' => 'required',
        'city_dest' => 'required',
    ];

    protected $messages = [
        'name.required' => 'The name field is required.',
        'name.min' => 'The name must be at least 2 min characters.',
        'name.max' => 'The name may not be greater than 50 max characters.',
        'phone_number.required' => 'The phone number field is required.',
        'phone_number.min' => 'The phone number must be at least 2 min characters.',
        'phone_number.max' => 'The phone number may not be greater than 20 max characters.',
        'address.required' => 'The address field is required.',
        'postal_code.required' => 'The postal code field is required.',
        'postal_code.min' => 'The postal code must be at least 2 min characters.',
        'postal_code.max' => 'The postal code may not be greater than 8 max characters.',
        'province_dest.required' => 'The province field is required.',
        'city_dest.required' => 'The city field is required.',
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

            // check if all products are available

            $order = $this->order->first();
            if (!$this->checkStockAvailability($order)) {
                return redirect()->route('merchandise.cart')->with('message', 'Cart items exceed stock limits. Please update your cart.');
            }
        }

        $this->user = User::where('id', Auth::user()->id)->first();

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

        $order = $this->order->first();

        if (!empty($order)) {

            //select province and city if user has already filled the address
            if ($this->user->province_id) {
                $this->province_dest = $this->user->province_id;
                $this->cities = City::where('province_id', $this->user->province_id)->pluck('title', 'city_id')->toArray();
            }

            if ($this->user->city_id) {
                $this->city_dest = $this->user->city_id;
                $this->updatedCityDest($this->city_dest);
            }

            $this->total_price = $order->total_price;
            $this->total_weight = $order->total_weight;

            //modify displayed weight
            $remainder = $this->total_weight % 1000;
            $quotient = intval($this->total_weight / 1000);

            if ($remainder > 300) {
                $this->displayed_weight = $quotient + 1;
            } else {
                if ($quotient == 0) {
                    $this->displayed_weight = 1;
                } else {
                    $this->displayed_weight = $quotient;
                }
            }
        } else {
            return redirect()->route('merchandise.home');
        }
    }

    public function updatedProvinceDest($value)
    {


        if ($value) {
            $province = Province::find($value);
            $this->cities = $province->cities()->pluck('title', 'city_id')->toArray();
        } else {
            $this->cities = [];
        }
        $this->cost = null;
        $this->city_dest = null;
        $this->courier = null;
        $this->service = null;
        $this->resetErrorBag();
    }

    public function updatedCityDest($value)
    {
        $order = $this->order->first();

        if (!empty($order)) {
            $this->total_price = $order->total_price;
            $this->total_weight = $order->total_weight;
        }

        if ($value) {
            // $this->isLoading = true;
            $fee = RajaOngkir::ongkosKirim([
                'origin' => 23, // ID kota/kabupaten asal
                'destination' => $this->city_dest, // ID kota/kabupaten tujuan
                'weight' => $this->total_weight, // berat barang dalam gram
                'courier' => 'jne' // kode kurir pengantar ( jne / tiki / pos )
            ])->get();

            if (isset($fee[0]['costs'][0])) {
                $this->shippingAvailable = true;
                if (isset($fee[0]['costs'][1])) {
                    $this->cost = $fee[0]['costs'][1]['cost'][0]['value'];
                    $this->service = $fee[0]['costs'][1]['service'];
                    $this->courier = $fee[0]['name'];
                } else {
                    $this->cost = $fee[0]['costs'][0]['cost'][0]['value'];
                    $this->service = $fee[0]['costs'][0]['service'];
                    $this->courier = $fee[0]['name'];
                }
            } else {
                $this->shippingAvailable = false;
                $this->cost = null;
                // $this->city_dest = null;
                $this->courier = null;
                $this->service = null;
            }

            // $this->isLoading = false;

            $this->resetErrorBag();
        }
    }

    public function checkout()
    {

        $this->validate([
            'name' => 'required|min:2|max:50',
            'phone_number' => 'required|min:2|max:20',
            'address' => 'required',
            'postal_code' => 'required|min:2|max:8',
            'province_dest' => 'required',
            'city_dest' => 'required',
        ]);

        $shippingFee = 0;


        $shippingOptions = RajaOngkir::ongkosKirim([
            'origin' => 23, // ID kota/kabupaten asal
            'destination' => $this->city_dest, // ID kota/kabupaten tujuan
            'weight' => $this->total_weight, // berat barang dalam gram
            'courier' => 'jne' // kode kurir pengantar ( jne / tiki / pos )
        ])->get();

        if (isset($shippingOptions[0]['costs'][0])) {
            $this->shippingAvailable = true;
            if (isset($shippingOptions[0]['costs'][1])) {
                $shippingFee = $shippingOptions[0]['costs'][1]['cost'][0]['value'];
                // $this->service = $shippingOptions[0]['costs'][1]['service'];
                // $this->courier = $shippingOptions[0]['name'];
            } else {
                $shippingFee = $shippingOptions[0]['costs'][0]['cost'][0]['value'];
                // $this->service = $shippingOptions[0]['costs'][0]['service'];
                // $this->courier = $shippingOptions[0]['name'];
            }
        } else {

            return redirect()->back()->with('message', 'Shipping is not available for your address.');

            // $this->shippingAvailable = false;
            // $this->cost = null;
            // // $this->city_dest = null;
            // $this->courier = null;
            // $this->service = null;
        }

        // dd($this->province_dest, $this->city_dest, $shippingFee);
        $this->validate();

        // update user profile
        $user = User::where('id', Auth::user()->id)->first();
        $user->name = $this->name;
        $user->phone_number = $this->phone_number;
        $user->address = $this->address;
        $user->province_id = $this->province_dest;
        $user->city_id = $this->city_dest;
        $user->postal_code = $this->postal_code;
        $user->update();


        // update order status
        $order = $this->order->first();
        $order->notes = $this->notes;
        $order->name = $this->name;
        $order->phone_number = $this->phone_number;
        $order->address = $this->address;
        $order->shipping_fee = $shippingFee;
        $order->province_id = $this->province_dest;
        $order->city_id = $this->city_dest;
        $order->postal_code = $this->postal_code;
        $order->status = 1;



        // Check if all products in the order have available stock
        if (!$this->checkStockAvailability($order)) {
            return redirect()->route('merchandise.cart')->with('message', 'Cart items exceed stock limits. Please update your cart.');
        }

        // Decrease stock for products in the order
        $this->decreaseStock($order);


        $order_to_email = Order::with('orderDetails.merchandise')
            ->where('id', $order->id)
            ->get();


        $province_to_mail = $order->province->title;
        $city_to_mail = $order->city->title;

        // dd($order_to_email, $province_to_mail, $city_to_mail);

        $messageData = [
            'name' => $order->name,
            'email' => $user->email,
            'phone_number' => $order->phone_number,
            'address' => $order->address . ', ' . $city_to_mail . ', ' . $province_to_mail . ', ' . $order->postal_code,
            'postal_code' => $order->postal_code,
            'order' => $order_to_email,
        ];

        $emailController = new EmailController();
        $emailController->newOrderNotificationEmail($messageData);

        $order->update();

        // $this->emit('masukKeranjang');

        return redirect()->route('proof-upload', ['orderId' => $order->id]);
    }

    protected function checkStockAvailability($order)
    {
        foreach ($order->orderDetails as $orderDetail) {
            $merchandise = $orderDetail->merchandise;

            if ($orderDetail->quantity > $merchandise->stock) {
                return false; // Product not available, return false immediately
            }
        }

        return true; // All products are available
    }

    protected function decreaseStock($order)
    {
        // Array to store product data for bulk update
        $productData = [];

        foreach ($order->orderDetails as $orderDetail) {
            $merchandise = $orderDetail->merchandise;
            $newStock = $merchandise->stock - $orderDetail->quantity;

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


    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('title', 'city_id');
        return json_encode($city);
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

        // $couriers = Courier::pluck('title', 'code');
        $provinces = Province::pluck('title', 'province_id');

        return view('livewire.merchandise.checkout', [
            'orders' => $this->order,
            'order_details' => $orderDetails,
            'courier' => $this->courier,
            'service' => $this->service,
            'provinces' => $provinces,
            'cities' => $this->cities,
            'cost' => $this->cost,
            'shippingAvailable' => $this->shippingAvailable,
            'user' => $this->user,

        ])->extends('layouts.merchandise.main');
    }
}
