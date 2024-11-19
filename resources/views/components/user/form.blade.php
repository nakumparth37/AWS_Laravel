<div>
    <form  {{ $attributes->merge(['method' => "post"]) }}>
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control name" name="name" id="name" aria-describedby="name"  value="{{ $user->name }}">
            <span class="text-danger error-name" id="error-name"></span>
            <input type="hidden" id="userID">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Surname</label>
            <input type="text" class="form-control email" name="surname" id="surname" aria-describedby="surname"  value="{{ $user->surname }}">
            <span class="text-danger error-surname" id="error-surname"></span>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control email" name="email" id="email" aria-describedby="email"  value="{{ $user->email }}">
            <span class="text-danger error-email" id="error-email"></span>
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Phone Number</label>
            <input type="number" class="form-control email" name="phone_number" id="phone_number" aria-describedby="phone_number"  value="{{ $user->phone_number }}">
            <span class="text-danger error-phone_number" id="error-phone_number"></span>
        </div>
        <div class="mb-3">
            <label for="role_type" class="form-label">Role</label>
            <select class="form-select form-select role_type" name="role_type" id="role_type">
                    <option value="">Select Role</option>
                    @foreach($roles as $roleId => $roleName)
                        <option value="{{ $roleId }}">{{ $roleName }}</option>
                    @endforeach
            </select>
            <span class="text-danger error-role_type" id="error-role_type"></span>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn text-dark d-flex align-middle" id="{{ $submitButtonId }}">
                <div class="px-3 pt-1">
                    {{ $submitButtonText}}
                </div>
                <div class="spinner-border text-primary d-none" role="status"  id="UserLoader">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </button>
        </div>
    </form>
</div>
