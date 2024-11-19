@extends('layouts')

@section('content')
    <div class="container">
        <div class="row justify-content-center mt-5">
            <x-profile-sidebar />
            <div class="col-md-8">
                <div class="row justify-content-center mt-5">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">Change password</div>
                            <div class="card-body">
                                <form action="{{ route('changes.password') }}" method="post">
                                    @csrf
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
                                    <div class="mb-3 row">
                                        <label for="password_confirmation"
                                            class="col-md-4 col-form-label text-md-end text-start">Confirm Password</label>
                                        <div class="col-md-6">
                                            <input type="password" class="form-control" id="password_confirmation"
                                                name="password_confirmation">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Set New Password">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
