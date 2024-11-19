@extends('layouts')

@section('content')
<div class="row justify-content-center mt-5">
    @foreach($products as $product)
        <a  href="{{ route('showProduct', $product->id) }}" class="card mx-1" style="width: 18rem;">
            <img src="{{ $product->thumbnail}}" class="card-img-top" alt="{{ $product->title }}">
            <div class="card-body">
              <h5 class="card-title">{{ $product->title }}</h5>
              <p class="card-text">{{ Str::limit($product->description,50) }}</p>
              <p class="card-text">Price: ${{ $product->price }}</p>
            </div>
        </a>
    @endforeach
@endsection
