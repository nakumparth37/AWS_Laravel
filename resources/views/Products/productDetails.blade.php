@extends('layouts')
@push('styles')
    <link rel="stylesheet" href="{{ asset('/css/productDetails.css') }}">
@endpush
@section('content')
    <div class="row justify-content-center mt-5">
        <div class = "card-wrapper">
            <div class = "productCard">
                <div class = "product-imgs">
                    <div class = "img-display">
                        <div class = "img-showcase">
                            @foreach ($product->images as $image)
                                <img class="mainProductImg" src = "{{ $image }}" alt = "shoe image">
                            @endforeach
                        </div>
                    </div>
                    <div class = "img-select">
                        @foreach ($product->images as $image)
                            <div class = "img-item">
                                <a href = "#" data-id = "{{ $loop->index + 1 }}">
                                    <img src = "{{ $image }}" alt = "shoe image">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- productCard right -->
                <div class = "product-content">
                    <h2 class = "product-title">{{ $product->title }}</h2>
                    <a href = "#" class = "product-link">visit {{ $product->brand }} store</a>

                    <div class = "product-price">
                        <p class = "new-price">Price: <span>${{ $product->price }}</span></p>
                    </div>

                    <div class = "product-detail">
                        <h2>about this item: </h2>
                        <p>{{ $product->description }}</p>
                        <ul>
                            <li>Available: <span>in stock</span></li>
                            <li>Category: <span>Shoes</span></li>
                            <li>Shipping Area: <span>All over the world</span></li>
                            <li>Shipping Fee: <span>Free</span></li>
                        </ul>
                    </div>

                    <div class = "purchase-info">
                        @guest
                            <a class="btn" href="{{ route('login') }}">Login</a>
                        @else
                            <div class="d-flex">
                                <form action="{{ route('processTransaction') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="product" value="{{ $product }}">
                                    <button type="submit" class="btn">Buy Now</button>
                                </form>
                                <form action="{{ route('cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="productId" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-primary">Add To Cart</button>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endsection

    @push('scripts')
    <script src="{{ asset('/js/productDetails.js') }}"></script>
    @endpush
