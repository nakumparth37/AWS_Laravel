const Swal = require('sweetalert2');
import { BASE_URL,showPreviewImg } from './app.js';

$(document).ready(function () {
    //show the form Input errors
    function showInputErrors(errorResponse) {
        var responseError = errorResponse.responseJSON.errors;
        for (const iterator in responseError) {
            $(`.${iterator}`).addClass('is-invalid');
            console.log(`.error-${iterator}`);
            console.log(responseError[iterator][0]);
            $(`.error-${iterator}`).text(responseError[iterator][0]);
        }
    }

    //clear the all Input errors after the close the modal and remove old users details
    function clearInputErrors(formID) {
        $('#name').val('');
        $('#email').val('');
        $('#role_type').val('');
        console.log(formID);
        var inputFields = $(`#${formID}`).find("input");
        var selectFields = $(`#${formID}`).find("select");
        inputFields.each(function() {
            if ($(this).attr("id")) {
                 $(`.${$(this).attr("id")}`).removeClass('is-invalid');
                 $(`.error-${$(this).attr("id")}`).text('');
            }
        });
        selectFields.each(function() {
            if ($(this).attr("id")) {
                 $(`.${$(this).attr("id")}`).removeClass('is-invalid');
                 $(`.error-${$(this).attr("id")}`).text('');
            }
        });
    }

    //Load the Uses Listing data-table
    var table = $('#user-listing-table').DataTable({
        ajax: `${BASE_URL}admin/user-listing`,
        columns: [
            {data: 'id', name: 'id'},
            {data: 'profileImage', name: 'profileImage'},
            {data: 'name', name: 'name'},
            {data: 'surname', name: 'surname'},
            {data: 'email', name: 'email'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'role_id', name: 'role_id'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    //Get user details
    $(document).on('click' , '.editUserData' ,function () {
        clearInputErrors("userUpdateForm");
        let userID = this.id;
        $.ajax({
            type: "GET",
            url: `${BASE_URL}admin/user/edit-${userID}`,
            success: function (response) {
                var userData = response.userData;
                $('#name').val(userData.name);
                $('#email').val(userData.email);
                $('#role_type').val(userData.role_id);
                $('#surname').val(userData.surname);
                $('#phone_number').val(userData.phone_number);
                $('#userID').attr('value',userData.id);
            }
        });

        //Update user details API class
        $("#saveUserData").click(function(event) {
        event.preventDefault();
        var formDataObj = $("#userUpdateForm").serializeArray();
        let userFormUpdateUrl = `${BASE_URL}admin/user/update-${$("#userID").val()}`;
        $.ajax({
            type: "POST",
            url: userFormUpdateUrl,
            data : formDataObj,
            success: function (response) {
                toastr.success(response.massage);
                $("#editUser").modal("hide");
                setTimeout(() => {
                    location.reload();
                }, 3000);
            },
            error: function(error) {
                showInputErrors(error);
            }
        });
        })
        console.log(userID);

    })


     $(document).on('click' , '#addUserData' ,function (event) {
        clearInputErrors("userAddForm");
        event.preventDefault();
        let userFormUpdateUrl = `${BASE_URL}admin/user/addNew`;
        var formDataObj = $("#userAddForm").serializeArray();
        console.log(formDataObj);
        console.log(userFormUpdateUrl);
        $.ajax({
            type: "POST",
            url: userFormUpdateUrl,
            data : formDataObj,
            beforeSend: function() {
                $("#UserLoader").removeClass('d-none')
            },
            success: function (response) {
                 $("#UserLoader").addClass('d-none');
                toastr.success(response.massage);
                $("#addUser").modal("hide");
                setTimeout(() => {
                    location.reload();
                }, 3000);
            },
            error: function(error) {
                 $("#UserLoader").addClass('d-none');
                console.log(error.responseJSON.errors);
                showInputErrors(error);

            }
        });
    })

    $(document).on('click' , '.deleteUser' ,function () {
        let userID = this.id;
        let userFormUpdateUrl = `${BASE_URL}admin/user/delete-${userID}`;
        console.log(userFormUpdateUrl);
        Swal.fire({
            title: "Are you sure Yoy want to delete this User?",
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
                        toastr.success(response.massage);
                        setTimeout(() => {
                            location.reload();
                        }, 3000);
                    },
                    error: function(error) {
                        showInputErrors(error);
                    }
                });
            }
        });
    })

    $("#profileImage").change(function (e) {
        e.preventDefault();
        showPreviewImg(this, 'div.imagesPreview', 'userImage')
    });

});

