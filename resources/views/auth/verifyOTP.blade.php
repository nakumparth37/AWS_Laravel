@extends('layouts')

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Verify Email OTP</div>
                <div class="card-body">
                    <form action="{{ route('verifyEmailOTP') }}" method="post">
                        @csrf
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">Email Address</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email"
                                    value="{{ old('email') ? old('email') : session('otp_email') }}" readonly>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="email" class="col-md-4 col-form-label text-md-end text-start">OTP </label>
                            <div class="col-md-6">
                                <input type="number" class="form-control @error('emailOTP') is-invalid @enderror"
                                    id="emailOTP" name="emailOTP" value="{{ old('emailOTP') }}">
                                @if ($errors->has('emailOTP'))
                                    <span class="text-danger">{{ $errors->first('emailOTP') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="verify OTP">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
