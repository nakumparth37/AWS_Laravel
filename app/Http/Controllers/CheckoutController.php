<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = Auth::user()->carts()->with('product')->get();
        return view('checkout.index', compact('cartItems'));
    }
}
