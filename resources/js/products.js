const Swal = require('sweetalert2');
import { showPreviewImg,BASE_URL,csrfToken } from './app.js';
// const showPreviewImg = require('./app.js');
toastr.options = {
    "closeButton": true,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
}


$(document).ready(function () {
    var productListing = $('#product-listing-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: `${BASE_URL}admin/product-listing`,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'brand', name: 'brand'},
            {data: 'title', name: 'title'},
            {data: 'price', name: 'price'},
            {data: 'discountPercentage', name: 'discountPercentage'},
            {data: 'rating', name: 'rating'},
            {data: 'stock', name: 'stock'},
            {data: 'Subcategory', name: 'Subcategory'},
            {data: 'categoryId', name: 'categoryId'},
            {data: 'sellerId', name: 'sellerId'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $(document).on('click' , '.deleteProduct' ,function () {
        let productID = this.id;
        let userFormUpdateUrl = `${BASE_URL}admin/products/delete-${productID}`;

        Swal.fire({
            title: "Are you sure Yoy want to delete this Product?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "GET",
                    url: userFormUpdateUrl,
                    success: function (response) {
                        toastr.success(response.Message);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    },
                    error: function(error) {
                        // console.log();
                        toastr.error(error.responseJSON.massage);

                    }
                });
            }
        });
    })

    //List of all category and make option menu
    $.ajax({
        type: "GET",
        url: `${BASE_URL}admin/getCategory`,
        success: function (response) {
            $.each(response.categories, function(index, category) {
                $('#productCategory').append($('<option>', {
                    value: category.id,
                    text: category.category_Name,
                    class: "text-capitalize"
                }));
            });

        }
    });

    //List of all Subcategory and make option menu
    $(document).on('click', '#productCategory', function(){
        var categoryID = this.value;
        if (categoryID) {
            $("#hiddeSubCategory").removeClass('d-none')
            $.ajax({
                type: "POST",
                url: `${BASE_URL}admin/getFilterSubCategory-${categoryID}`,
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Include CSRF token in the headers
                },
                success: function (response) {
                    $('#subCategory').empty();
                    $('#subCategory').append($('<option>', {
                        value: '',
                        text: 'Select Sub category',
                        class: "text-capitalize"
                    }));
                    $.each(response.subCategories, function(index, subcategory) {
                        $('#subCategory').append($('<option>', {
                            value: subcategory.id,
                            text: subcategory.Sub_category_Name,
                            class: "text-capitalize"
                        }));
                    });

                }
            });
        }
    })

    //List of all seller and make option
    $.ajax({
        type: "GET",
        url: `${BASE_URL}admin/getSellerList`,
        success: function (response) {
            $.each(response.seller, function(index, seller) {
                $('#seller').append($('<option>', {
                    value: seller.id,
                    text: seller.name,
                    class: "text-capitalize"
                }));
            });

        }
    });

    $("#thumbnail").change(function (e) {
        e.preventDefault();
        showPreviewImg(e.target, 'div.thumbnailPreview', 'productImage')
    });

    $("#images").change(function (e) {
        e.preventDefault();
        showPreviewImg(e.target, 'div.imagesPreview', 'productImage');
    });

    var productListing = $('#seller-product-listing-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: `http://laravel1.parth.nakum.radixusers2.com/seller/product-listing`,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'brand', name: 'brand'},
            {data: 'title', name: 'title'},
            {data: 'price', name: 'price'},
            {data: 'discountPercentage', name: 'discountPercentage'},
            {data: 'rating', name: 'rating'},
            {data: 'stock', name: 'stock'},
            {data: 'Subcategory', name: 'Subcategory'},
            {data: 'categoryId', name: 'categoryId'},
            {data: 'sellerId', name: 'sellerId'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
})
