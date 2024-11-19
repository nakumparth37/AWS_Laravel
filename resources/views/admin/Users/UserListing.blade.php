@extends('admin.dashboard')

@section('adminMainContant')
<div class="admin-content-continuer">
    <div class="mx-5 mt-5">
        <div class="d-flex justify-end gap-2">
          <button name="addNewUser" id="addNewUser" class="btn btn-success" data-bs-toggle='modal' data-bs-target='#addUser'>+ <i class="fa-solid fa-user"></i></button>
        </div>
        <table class="table table-striped data-table table-hover " id="user-listing-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <x-user.from-modal title="Modify User Details" id="editUser" fromId="userUpdateForm" submitButtonText="Save User" submitButtonId="saveUserData" ></x-user.from-modal>
    <x-user.from-modal title="Add New User" id="addUser" fromId="userAddForm" submitButtonText="Add New" submitButtonId="addUserData" ></x-user.from-modal>

@endsection

