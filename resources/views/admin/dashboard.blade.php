@extends('layouts')

@section('content')
    <div class="row main-admin-continuer position-fix w-100">
        <div class="col-2">
            @include('partials.admin_sidebar')
        </div>    
        <div class="col-10">
            @yield('adminMainContant')
        </div>
        
    </div>

@endsection
