<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    protected function cart()
    {
        return session()->get('cart', []);
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = $this->cart();
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += 1;
        } else {
            $cart[$productId] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image
            ];
        }
        session(['cart' => $cart]);
        return back()->with('success','Added to cart');
    }

    public function remove(Request $request, $productId)
    {
        $cart = $this->cart();
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
        }
        return back();
    }

    public function view()
    {
        $cart = $this->cart();
        $coupon = session('coupon', null);
        return view('cart.index', compact('cart','coupon'));
    }
    public function update(Request $request, $id)
{
    $cart = $this->cart();

    if (!isset($cart[$id])) {
        return back()->with('error', 'Item not found in cart');
    }

    $qty = max(1, (int)$request->quantity); 

    $cart[$id]['quantity'] = $qty;

    session(['cart' => $cart]);

    return back()->with('success', 'Cart updated');
}


    public function applyCoupon(Request $request)
    {
        $code = $request->input('coupon');
        $coupon = Coupon::where('code', $code)->where('is_active', true)->first();
        if (!$coupon) {
            return back()->with('error','Invalid coupon');
        }
        if ($coupon->expires_at && $coupon->expires_at->isPast()) {
            return back()->with('error','Coupon expired');
        }
        session(['coupon' => $coupon->toArray()]);
        return back()->with('success','Coupon applied');
    }

    public function checkout(Request $request)
    {
        $cart = $this->cart();
        if (empty($cart)) return back()->with('error','Cart empty');

        $coupon = session('coupon', null);

        DB::beginTransaction();
        try {
            $subtotal = array_reduce($cart, function($carry,$item){ return $carry + ($item['price']*$item['quantity']); }, 0);
            $discount = 0;
            if ($coupon) {
                if ($coupon['type'] === 'percent') {
                    $discount = ($coupon['value']/100) * $subtotal;
                } else {
                    $discount = min($coupon['value'], $subtotal);
                }
            }
            $total = max(0, $subtotal - $discount);

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'processing',
                'meta' => [
                    'subtotal' => $subtotal,
                    'discount' => $discount,
                    'coupon' => $coupon ? $coupon['code'] : null
                ]
            ]);

            foreach ($cart as $c) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $c['id'],
                    'quantity' => $c['quantity'],
                    'unit_price' => $c['price'],
                    'total_price' => $c['price'] * $c['quantity']
                ]);
            }

            DB::commit();
            // Clear cart
            session()->forget(['cart','coupon']);
            return redirect()->route('cart.completed', $order->id)->with('success','Order placed');
        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error','Checkout failed: '.$e->getMessage());
        }
    }

    public function completed($orderId)
    {
        $order = Order::with('items.product')->findOrFail($orderId);
        return view('cart.completed', compact('order'));
    }
}
