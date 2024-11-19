@extends('layouts')

@section('content')
    <div class="container">
        <h1 class="my-4">Shopping Cart</h1>

        @if ($cartItems->isEmpty())
            <p>Your cart is empty.</p>
        @else
            <div class="row">

                <div class="col-md-8">
                    <h4>Cart ({{ $cartItems->count() }} items)</h4>
                    @foreach ($cartItems as $item)
                        <div class="card mb-3">
                            <div class="row g-0">
                                <div class="col-md-4 p-3">
                                    <img src="{{ $item->product->thumbnail }}" class="img-fluid rounded-start"
                                        alt="{{ $item->product->title }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->product->title }}</h5>
                                        <p class="card-text">Description: {{ $item->product->description }}</p>
                                        <div class="d-flex justify-content-between">
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                <div class="input-group">
                                                    <input type="number" name="quantity" value="{{ $item->quantity }}"
                                                        min="1" max="5" step="1" class="form-control"
                                                        style="max-width: 60px;">
                                                    <button type="submit" class="btn btn-outline-secondary">Update</button>
                                                </div>
                                            </form>
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Remove</button>
                                            </form>
                                        </div>
                                        <div class="d-flex justify-content-between mt-5">
                                            <p class="card-text mt-2">Price: ${{ $item->product->price }}</p>
                                            <p class="card-text mt-2">Total: ${{ $item->product->price * $item->quantity }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-md-4 mt-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center mb-3 bg-primary bg-gradient rounded ">
                                <h4 class="text-white pt-2">Shopping Summery</h4>
                            </div>
                            <div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Item</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($cartItems as $item)
                                                <tr class="">
                                                    <td scope="row">{{ Str::limit($item->product->title, 25) }}</td>
                                                    <td>{{ $item->product->price }}</td>
                                                    <td>x {{ $item->quantity }}</td>
                                                </tr>
                                            @endforeach
                                            <tr class="">
                                                <td scope="row" colspan="2">
                                                    <h5 class="card-title">Items</h5>
                                                </td>
                                                <td>
                                                    <h5>{{ $cartItems->sum(fn($item) => $item->quantity) }}</h5>
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td scope="row" colspan="2">
                                                    <h5 class="card-title">The total amount</h5>
                                                </td>
                                                <td>
                                                    <h5>${{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}
                                                    </h5>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h5 class="card-text">The total amount of (Including Tax):
                                ${{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}</h5>
                            <a href="{{ route('checkout.index') }}" class="btn btn-primary d-block mt-5">Go To Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
