<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->carts()->with('product')->get();
        return view('cart.index', compact('cartItems'));
    }

    public function addToCart(Request $request)
    {
        try {
            $product = Product::find($request->productId);

            $cart = Auth::user()->carts()->where('product_id', $product->id)->first();

            if ($cart) {
                $cart->quantity += 1;
                $cart->save();
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => 1,
                ]);
            }

            return redirect()->route('cart.index')->with('success',"Cart has been added successfully in cart");
        } catch (Exception $e) {
            return redirect()->route('cart.index')->with('error',$e->getMessage());
        }
    }

    public function updateQuantity(Request $request,$cartId)
    {
        try {
            $cart = Cart::find($cartId);
            $cart->quantity = $request->quantity;
            $cart->save();
            return redirect()->route('cart.index')->with('success',"product has been Updated successfully in cart");
        } catch (Exception $e) {
            return redirect()->route('cart.index')->with('error',$e->getMessage());
        }
    }

    public function removeIte($cartId)
    {
        try {
            $cart = Cart::find($cartId);
            $cart->delete();
            return redirect()->route('cart.index')->with('success',"product has been removed successfully in cart");
        } catch (Exception $e) {
            return redirect()->route('cart.index')->with('error',$e->getMessage());
        }
    }
}
