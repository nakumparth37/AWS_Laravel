@extends('errors.layout')
@section('title', '419 Page Expired')
@section('content')
<div class="container">
    <div class="error_404">
        <img src="{{ url('images/419_error.webp') }}" alt="Maintenance" class="maintenance-image" >
        <h1>419</h1>
        The page has expired due to inactivity.
        <br/><br/>
        Please refresh and try again.
    <div>
</div>
@endsection
@endsection
