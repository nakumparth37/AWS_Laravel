@extends('admin.dashboard')

@section('adminMainContant')
    <div class="admin-content-continuer">
        <div class="mx-5 mt-5">
            <div class="row">
                <div class="col-12 mt-5">
                    <div class="d-flex justify-content-center  ">
                        <div class="col-10 ">
                            <h3 class="mb-5 pb-2 fs-2">Add New product</h3>
                            <form action="{{ route('product.addProduct') }}" method="post" encType="multipart/form-data"
                                class="addProduct" id="addProduct">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label htmlFor="title" class="form-label">Title</label>
                                            <input type="text" name="title" id="title"
                                                class="form-control @error('title') is-invalid @enderror"
                                                placeholder="Enter Product Title" aria-describedby="e_title" value="{{ old('title') }}"/>
                                            @if ($errors->has('title'))
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label htmlFor="brand" class="form-label">Brand</label>
                                            <input type="text" name="brand" id="brand"
                                                class="form-control @error('brand') is-invalid @enderror"
                                                placeholder="Enter Brand Name" aria-describedby="e_brand" value="{{ old('brand') }}"/>
                                            @if ($errors->has('brand'))
                                                <span class="text-danger">{{ $errors->first('brand') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label htmlFor="category" class="form-label">Category</label>
                                                <select
                                                    class="form-select form-select @error('category') is-invalid @enderror"
                                                    name="category" id="productCategory" aria-describedby="e_category">
                                                    <option value=''>Select category</option>
                                                </select>
                                                @if ($errors->has('category'))
                                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <div class="mb-3 d-none" id="hiddeSubCategory">
                                                <label htmlFor="category" class="form-label">Sub Category</label>
                                                <select
                                                    class="form-select form-select  @error('subCategory') is-invalid @enderror"
                                                    name="subCategory" id="subCategory" aria-describedby="e_subCategory">
                                                    <option value=''>Select Sub category</option>
                                                </select>
                                                @if ($errors->has('category'))
                                                    <span class="text-danger">{{ $errors->first('category') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <div class="mb-3">
                                                <label htmlFor="category" class="form-label">Seller</label>
                                                <select
                                                    class="form-select form-select @error('seller') is-invalid @enderror"
                                                    name="seller" id="seller" aria-describedby="e_sseller">
                                                    <option value=''>Select Seller</option>
                                                </select>
                                                @if ($errors->has('seller'))
                                                    <span class="text-danger">{{ $errors->first('seller') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label htmlFor="discount" class="form-label">Discount Percentage</label>
                                            <input type="text" name="discountPercentage" id="discount"
                                                class="form-control @error('discountPercentage') is-invalid @enderror"
                                                placeholder="Enter Discount in Percentage"
                                                aria-describedby="e_discountPercentage" value="{{ old('discountPercentage') }}"/>
                                            @if ($errors->has('discountPercentage'))
                                                <span class="text-danger">{{ $errors->first('discountPercentage') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label htmlFor="stock" class="form-label">Stock</label>
                                            <input type="number" name="stock" id="stock"
                                                class="form-control @error('stock') is-invalid @enderror"
                                                placeholder="Enter Product Stock" aria-describedby="e_stock" value="{{ old('stock') }}"/>
                                            @if ($errors->has('stock'))
                                                <span class="text-danger">{{ $errors->first('stock') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-3">
                                            <label htmlFor="price" class="form-label">Price</label>
                                            <input type="text" name="price" id="price"
                                                class="form-control @error('price') is-invalid @enderror"
                                                placeholder="Enter Product price" aria-describedby="e_price" value="{{ old('price') }}"/>
                                            @if ($errors->has('price'))
                                                <span class="text-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row my-3">
                                    <div class="col-6 thumbnailPreview">

                                    </div>
                                    <div class="d-flex align-items-center flex-wrap col-6 imagesPreview">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label htmlFor="thumbnail" class="form-label">Thumbnail </label>
                                            <input type="file" name="thumbnail" id="thumbnail"
                                                class="form-control @error('thumbnail') is-invalid @enderror"
                                                aria-describedby="e_thumbnail"
                                                accept="mage/jpg,image/jpeg,image/webp,image/png" />
                                            @if ($errors->has('thumbnail'))
                                                <span class="text-danger">{{ $errors->first('thumbnail') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label htmlFor="images" class="form-label">Images</label>
                                            <input type="file" name="images[]" id="images"
                                                class="form-control @error('images') is-invalid @enderror"
                                                aria-describedby="e_images" multiple="multiple"
                                                accept="mage/jpg,image/jpeg,image/webp,image/png" />
                                            @if ($errors->has('images'))
                                                <span class="text-danger">{{ $errors->first('images') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label htmlFor="description" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                                        rows="6" placeholder="Enter Product Description" aria-describedby="e_description" value="{{ old('description') }}"></textarea>
                                    @if ($errors->has('description'))
                                        <span class="text-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                                <div class="mb-3 row m-1">
                                    <button name="submit" id="register" class="btn btn-primary">Add Product</button>
                                </div>

                                <div class="row justify-content-center " id="loading">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
