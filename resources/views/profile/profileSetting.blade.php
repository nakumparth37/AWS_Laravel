@extends('layouts')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <x-profile-sidebar />
            <div class="col-md-8">
                <div class='bg-white p-4 border rounded'>
                    <div class='my-3'>
                        <h5>Edit Profile</h5>
                    </div>
                    <div class='border p-4 rounded'>
                        <form action="{{ route('profile.save') }}" method="post" enctype='multipart/form-data'>
                            @csrf
                            <div class='d-flex flex-column align-items-center'>
                                <div class='m-0 imagesPreview'>
                                    <img src="{{ $user->profileImage ? $user->profileImage : $user->getProfileAvatar(150) }}" class="object-fit-cover rounded-circle" width=150 height=150 alt="{{$user->name}}"/>
                                </div>
                                <div class="mb-3" style="width: 100px;">
                                    <input type="file" class="form-control @error('profileImage') is-invalid @enderror" name="profileImage" id="profileImage" />
                                    @if ($errors->has('profileImage'))
                                        <span class="text-danger">{{ $errors->first('profileImage') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{ $user->name }}" placeholder="Type Name" />
                                @if ($errors->has('name'))
                                    <span class="text-danger">{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="surname" class="form-label">Surname</label>
                                <input type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" id="surname" value="{{ $user->surname }}" placeholder="Type Surname" />
                                @if ($errors->has('surname'))
                                    <span class="text-danger">{{ $errors->first('surname') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" value="{{ $user->email }}" placeholder="Type Email" />
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">Phone Number</label>
                                <input type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" id="phone_number" value="{{ $user->phone_number }}" placeholder="Type Contact Number" />
                                @if ($errors->has('phone_number'))
                                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                                @endif
                            </div>
                            <h5 class='mt-3'>Address</h5>
                            <div class="row">
                                <div class="col-sm-3 mb-3">
                                    <label for="addressLine1" class="form-label">Address Line 1</label>
                                    <input type="text" class="form-control @error('addressLine1') is-invalid @enderror" id='addressLine1' placeholder="Type here" name="addressLine1" value="{{ $user->addressLine1 }}" />
                                    @if ($errors->has('addressLine1'))
                                        <span class="text-danger">{{ $errors->first('addressLine1') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label for="addressLine2" class="form-label">Address Line 2</label>
                                    <input type="text" class="form-control @error('addressLine2') is-invalid @enderror" id='addressLine2' placeholder="Type here" name="addressLine2" value="{{ $user->addressLine2 }}" />
                                    @if ($errors->has('addressLine2'))
                                        <span class="text-danger">{{ $errors->first('addressLine2') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" name="city" id='city' placeholder='Type here' value="{{ $user->city }}" />
                                    @if ($errors->has('city'))
                                        <span class="text-danger">{{ $errors->first('city') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-3 mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror" id='country' placeholder="Type here" name="country" value="{{ $user->country }}" />
                                    @if ($errors->has('country'))
                                        <span class="text-danger">{{ $errors->first('country') }}</span>
                                    @endif
                                </div>
                                <div class="col-sm-3 col-6 mb-3">
                                    <label for="state" class="form-label">State</label>
                                    <input type="text" class="form-control @error('state') is-invalid @enderror" name="state" id='state' placeholder='Type here' value="{{ $user->state }}" />
                                    @if ($errors->has('state'))
                                        <span class="text-danger">{{ $errors->first('state') }}</span>
                                    @endif
                                </div>

                                <div class="col-sm-3 col-6 mb-3">
                                    <label for="pinCode" class="form-label">Pin Code</label>
                                    <input type="number" class="form-control @error('pinCode') is-invalid @enderror" name="pinCode" id='pinCode' placeholder='Type here' value="{{ $user->pinCode }}" />
                                    @if ($errors->has('pinCode'))
                                        <span class="text-danger">{{ $errors->first('pinCode') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary w-100"> Save  </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
