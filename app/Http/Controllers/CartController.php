<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private function getOrCreateCart()
    {
        return Cart::firstOrCreate(['user_id' => auth()->id()]);
    }

    public function index()
    {
        $cart        = Cart::where('user_id', auth()->id())->with('items.product')->first();
        $discountPct = (int) Setting::get('store_discount_percent', 0);
        $subtotal    = 0;
        $discount    = 0;
        $total       = 0;

        if ($cart) {
            foreach ($cart->items as $item) {
                $subtotal += $item->product->price * $item->quantity;
            }
            $discount = round($subtotal * $discountPct / 100);
            $total    = $subtotal - $discount;
        }

        return view('cart.index', compact('cart', 'subtotal', 'discount', 'total', 'discountPct'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($request->product_id);

        if (!$product->isInStock()) {
            return back()->with('error', 'Sorry, this product is out of stock.');
        }

        $cart = $this->getOrCreateCart();
        $item = CartItem::where('cart_id', $cart->id)->where('product_id', $product->id)->first();

        if ($item) {
            $newQty = min($item->quantity + $request->quantity, $product->stock_quantity);
            $item->update(['quantity' => $newQty]);
        } else {
            CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => min($request->quantity, $product->stock_quantity),
            ]);
        }

        return back()->with('success', "'{$product->name}' added to cart!");
    }

    public function update(Request $request, CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);
        $request->validate(['quantity' => 'required|integer|min:1|max:99']);

        $cartItem->update(['quantity' => min($request->quantity, $cartItem->product->stock_quantity)]);

        return redirect()->route('cart.index')->with('success', 'Cart updated.');
    }

    public function remove(CartItem $cartItem)
    {
        $this->authorizeCartItem($cartItem);
        $cartItem->delete();
        return redirect()->route('cart.index')->with('success', 'Item removed from cart.');
    }

    private function authorizeCartItem(CartItem $item): void
    {
        $cart = Cart::where('user_id', auth()->id())->firstOrFail();
        if ($item->cart_id !== $cart->id) {
            abort(403);
        }
    }
}
