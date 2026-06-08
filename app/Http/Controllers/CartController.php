<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Rental;

class CartController extends Controller
{
    // Tambah ke cart (pakai session)
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        
        $id = $request->id;
        
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                'id' => $id,
                'name' => $request->name,
                'price' => $request->price,
                'quantity' => 1
            ];
        }
        
        session()->put('cart', $cart);
        
        return response()->json([
            'success' => true,
            'message' => 'Produk ditambahkan ke cart',
            'cart_count' => count($cart)
        ]);
    }
    
    // Lihat cart
    public function viewCart()
    {
        $cart = session()->get('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return view('cart.index', compact('cart', 'total'));
    }
    
    // Hapus item dari cart
    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        
        return redirect()->route('cart.view')->with('success', 'Produk dihapus dari cart');
    }
    
    // Checkout: pindah ke form sewa
    public function checkout()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Cart kosong');
        }
        
        // Simpan cart ke session temporary untuk checkout
        session()->put('checkout_cart', $cart);
        
        return redirect()->route('checkout.form');
    }
    
    // Form checkout (pilih durasi)
    public function checkoutForm()
    {
        $cart = session()->get('checkout_cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view');
        }
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.checkout', compact('cart', 'total'));
    }
    
    // FORM PEMBAYARAN (baru)
    public function paymentForm(Request $request)
    {
        $request->validate([
            'duration_value' => 'required|integer|min:1',
            'duration_unit' => 'required|in:hours,days',
        ]);
        
        $cart = session()->get('checkout_cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.view')->with('error', 'Cart kosong');
        }
        
        // Simpan durasi ke session
        session()->put('checkout_duration', [
            'value' => $request->duration_value,
            'unit' => $request->duration_unit
        ]);
        
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        return view('cart.payment', compact('cart', 'total'));
    }
    
    // Proses checkout (setelah pembayaran simulasi)
    public function processCheckout(Request $request)
{
    $request->validate([
        'payment_method' => 'required|in:credit_card,bank_transfer,ewallet',
    ]);

    $cart = session()->get('checkout_cart', []);
    $duration = session()->get('checkout_duration');

    if (empty($cart) || !$duration) {
        return redirect()->route('cart.view')->with('error', 'Data checkout tidak lengkap');
    }

    foreach ($cart as $item) {
        $product = Product::find($item['id']);
        if (!$product) {
            continue;
        }

        Rental::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'duration_value' => $duration['value'],
            'duration_unit' => $duration['unit'],
            'status' => 'waiting',
        ]);
    }

    // Simpan metode pembayaran ke session (opsional, buat record transaksi nanti)
    session()->put('last_payment_method', $request->payment_method);

    // Clear session
    session()->forget('cart');
    session()->forget('checkout_cart');
    session()->forget('checkout_duration');

    return redirect()->route('rentals.my')->with('success', 'Pembayaran berhasil! Pesanan Anda menunggu konfirmasi admin.');
}
    public function getCartCount()
{
    $cart = session()->get('cart', []);
    return response()->json(['count' => count($cart)]);
}
}