<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $discountPct = (int) Setting::get('store_discount_percent', 0);
        $subtotal    = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
        $discount    = round($subtotal * $discountPct / 100);
        $total       = $subtotal - $discount;
        $user        = auth()->user();

        return view('checkout.index', compact('cart', 'subtotal', 'discount', 'total', 'discountPct', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name'      => 'required|string|max:100',
            'email'          => 'required|email',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string|max:500',
            'payment_method' => 'required|in:esewa,cod',
        ]);

        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $discountPct = (int) Setting::get('store_discount_percent', 0);
        $subtotal    = $cart->items->sum(fn($i) => $i->product->price * $i->quantity);
        $discount    = round($subtotal * $discountPct / 100);
        $total       = $subtotal - $discount;

        $order = DB::transaction(function () use ($request, $cart, $subtotal, $discount, $total) {
            $order = Order::create([
                'user_id'        => auth()->id(),
                'order_number'   => 'GN-' . strtoupper(Str::random(8)),
                'full_name'      => $request->full_name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'address'        => $request->address,
                'subtotal'       => $subtotal,
                'discount_amount'=> $discount,
                'total_amount'   => $total,
                'order_status'   => 'pending',
                'payment_status' => 'unpaid',
                'payment_method' => $request->payment_method,
                'esewa_transaction_uuid' => ($request->payment_method === 'esewa') ? (string) Str::uuid() : null,
            ]);

            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $item->product->name,
                    'unit_price'   => $item->product->price,
                    'quantity'     => $item->quantity,
                    'line_total'   => $item->product->price * $item->quantity,
                ]);
            }

            return $order;
        });

        if ($request->payment_method === 'esewa') {
            return redirect()->route('payment.esewa.initiate', ['order' => $order->id]);
        }

        // COD — empty cart and confirm
        CartItem::where('cart_id', $cart->id)->delete();

        return redirect()->route('orders.confirm', $order->id)
                         ->with('success', 'Order placed! Our team will contact you for delivery.');
    }
}
