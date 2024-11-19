@extends('seller.dashboard')

@section('sellerMainContant')
    <div class="admin-content-continuer">
        <div class="mx-5 mt-5">
            <div class="d-flex justify-end gap-2">
                <a href="{{ route('seller_product.showForm') }}" type="button" name="addNewProduct" id="addNewProduct" class="btn btn-success"><i class="fa-solid fa-circle-plus"></i></i></a>
            </div>
            <table class="table table-striped data-table table-hover" id="seller-product-listing-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Brand</th>
                        <th>Title</th>
                        <th>Price</th>
                        <th>Discount Percentage</th>
                        <th>Rating</th>
                        <th>Stock</th>
                        <th>Subcategory</th>
                        <th>Category</th>
                        <th>Seller</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
@endsection
