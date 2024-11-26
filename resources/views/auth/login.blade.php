@extends('layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="{{ route('authenticate') }}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="password" class="col-md-4 col-form-label text-md-end text-start">Password</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password">
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row ">
                            <div class="form-check form-check-inline d-flex justify-content-center">
                                <input class="form-check-input mx-2" type="checkbox" name="remember" id="remember"
                                    value="true">
                                <label class="form-check-label" for="remember">Remember me</label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Login">
                        </div>
                        <div class="mb-3 row">
                            <a name="forget_password" id="" class="col-md-3 offset-md-5 btn btn-primary"
                                href="/forget_password" role="button">Forget Password</a>
                        </div>
                        <div class="d-flex justify-content-center ">
                            <p class="text-secondary my-3 login_text" >Login with</p>
                        </div>
                        <div class="mb-3 d-flex justify-content-center social_icon_container" >
                            <div class="col-1">
                                <a class="col-md-3 offset-md-5 " href="{{ route('login.github') }}">
                                    <i class="fa-brands fa-github text-secondary fs-1"></i>
                                </a>
                            </div>
                            <div class="col-1">
                                <a class="col-md-3 offset-md-5 " href="{{ route('login.google') }}">
                                    <img class="google_icon" src="{{ url('/') }}/images/google.png" alt="google" >
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
