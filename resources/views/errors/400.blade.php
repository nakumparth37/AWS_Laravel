@extends('errors.layout')
@section('title', '400 Bad request')
@section('content')
<div class="container">
    <div class="error_404">
        <img src="{{ url('images/419_error.gif') }}" alt="Maintenance" class="maintenance-image" >
        <h1>400</h1>
        <h2>Bad request.</h2>
        <p>
            <?php
            $default_error_message = "Please return to <a href='".url('')."'>our homepage</a>.";
            ?>
            {!! isset($exception)? ($exception->getMessage()?$exception->getMessage():$default_error_message): $default_error_message !!}
        </p>
        <a href="{{ url('/') }}">Back to Home</a>
    <div>
</div>
@endsection
@endsection
