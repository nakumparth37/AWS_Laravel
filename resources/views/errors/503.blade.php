@extends('errors.layout')
@section('title', '503 Service Unavailable')

@section('content')
<div class="container">
    <img src="{{ url('images/maintenance-image.png') }}" alt="Maintenance" class="maintenance-image" >
    <h2>Sorry! We Are Under Scheduled Maintenance</h2>
    <p>Our website is currently undergoing scheduled maintenance, we will be right back in a few
        minutes.<br>Thank you for your patience.</p>
</div>
@endsection
