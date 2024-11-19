@extends('layouts')

@section('content')
    <div class="container">
        <h1 class="my-4">Checkout</h1>
        <div class="row">
            <div class="col-md-8">
                <h4>Cart ({{ $cartItems->count() }} items)</h4>
                <div class="card">
                    <form action="{{ route('processTransaction') }}" method="post" class="p-3">
                        @csrf
                        <h5 class="mx-auto p-2">Shaaping Address</h5>
                        <div class="col-sm-12 mb-3">
                            <label htmlFor="address" class="form-label">Address Line 1</label>
                            <input type="text" class="form-control @error('addressLine1') is-invalid @enderror" name="addressLine1" id="addressLine1"placeholder='address Line 1' value="{{ old('addressLine1') }}"/>
                                @if ($errors->has('addressLine1'))
                                    <span class="text-danger">{{ $errors->first('addressLine2') }}</span>
                                @endif
                        </div>
                        <div class="col-sm-12 mb-3">
                            <label htmlFor="address" class="form-label">Address Line 2</label>
                            <input type="text" class="form-control @error('addressLine2') is-invalid @enderror" name="addressLine2" id="addressLine2" placeholder='address Line 2' value="{{ old('addressLine2') }}"></input>
                                @if ($errors->has('addressLine2'))
                                    <span class="text-danger">{{ $errors->first('addressLine2') }}</span>
                                @endif
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mb-3">
                                <label htmlFor="county" class="form-label">Country</label>
                                <input type="text" class="form-control @error('county') is-invalid @enderror" id='county' placeholder="Type here" name="county" value="{{ old('county') }}"/>
                                @if ($errors->has('county'))
                                    <span class="text-danger">{{ $errors->first('county') }}</span>
                                @endif
                            </div>

                            <div class="col-sm-3 col-6 mb-3">
                                <label htmlFor="state" class="form-label">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" id='state' placeholder='Type here' value="{{ old('state') }}"/>
                                @if ($errors->has('state'))
                                    <span class="text-danger">{{ $errors->first('state') }}</span>
                                @endif
                            </div>

                            <div class="col-sm-3 col-6 mb-3">
                                <label htmlFor="pinCode" class="form-label">Pin Code</label>
                                <input type="number" class="form-control @error('pinCode') is-invalid @enderror" name="pinCode" id='pinCode' placeholder='Type here' value="{{ old('pinCode') }}"/>
                                @if ($errors->has('pinCode'))
                                    <span class="text-danger">{{ $errors->first('pinCode') }}</span>
                                @endif
                            </div>

                            <div class="col-sm-3 mb-3">
                                <label htmlFor="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id='city' placeholder='Type here' value="{{ old('city') }}"/>
                                @if ($errors->has('city'))
                                    <span class="text-danger">{{ $errors->first('city') }}</span>
                                @endif
                                <input type="hidden" name="productData" value="{{ $cartItems->sum(fn($item) => $item->product->price * $item->quantity) }}">
                            </div>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn bg-warning mt-2 ">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h5>Pay with</h5>
                                    <img src="http://laravel1.parth.nakum.radixusers2.com/public/paypal.png" alt="paypal" style="width: 50px;height: 50px;">
                                </div>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <div class="card">
                    <div class="card-body">
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
                    </div>
                </div>
                <div class="mt-3">
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
                                        <p class="card-text">Description: {{ Str::limit($item->product->description,10) }}</p>
                                        <div class="d-flex justify-content-between ">
                                            <p class="card-text mt-2">Price: ${{ $item->product->price }}</p>
                                            <p class="card-text mt-2">Total: ${{ $item->product->price * $item->quantity }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
</div>
@endsection
