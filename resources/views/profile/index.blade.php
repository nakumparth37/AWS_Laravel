@extends('layouts')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <x-profile-sidebar />
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3>Profile Information</h3>
                        <hr>
                        <p><strong>Name:</strong> {{ $user->name }} {{ $user->surname }}</p>
                        <p><strong>Email Address:</strong> {{ $user->email }}</p>
                        <p><strong>Contact:</strong> {{ $user->phone_number }}</p>
                        <p><strong>Role:</strong> {{ $user->role->role_type }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
