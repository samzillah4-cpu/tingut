<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($request->product_id);
        if (!$product->is_for_sale) {
            return response()->json(['success' => false, 'error' => 'Product is not for sale']);
        }

        $total = $request->quantity * $product->sale_price;

        $cart = Cart::updateOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $request->product_id],
            ['quantity' => $request->quantity, 'total' => $total]
        );

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        return response()->json([
            'success' => true,
            'product_name' => $product->title,
            'cart_count' => $cartCount,
        ]);
    }

    public function index()
    {
        $carts = Cart::with('product')->where('user_id', Auth::id())->get();
        $total = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->product->sale_price;
        });
        return view('cart.index', compact('carts', 'total'));
    }

    public function count()
    {
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
