@extends('admin.dashboard')

@section('adminMainContant')
    <div class="admin-content-continuer">
        <div class="mx-5 mt-5">
            {{-- <div class="d-flex justify-end gap-2">
                <a href="{{ route('product.showForm') }}" type="button" name="addNewProduct" id="addNewProduct" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></i></a>
            </div> --}}
            <table class="table table-striped data-table table-hover" id="order-listing-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Transaction Id</th>
                        <th>Payment Id</th>
                        <th>User Id</th>
                        <th>Content</th>
                        <th>Address</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
@endsection
