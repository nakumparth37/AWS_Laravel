@extends('errors.layout')
@section('title', '404 Not Found')
@section('content')
@section('content')
<div class="container">
    <div class="error_404">
        <img src="{{ url('images/404_error.gif') }}" alt="Maintenance" class="maintenance-image" >
        <h1>404</h1>
        <h2>Oops! Page Not Found</h2>
        <p>We couldn't find the page you're looking for.</p>
        <a href="{{ url('/') }}">Back to Home</a>
    <div>
</div>
@endsection
@endsection
