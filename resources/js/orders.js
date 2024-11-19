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
	var productListing = $('#order-listing-table').DataTable({
		processing: true,
		serverSide: true,
		ajax: `${BASE_URL}admin/order-listing`,
		columns: [
			{data: 'id', name: 'id'},
			{data: 'transaction_id', name: 'transaction_id'},
			{data: 'payment_id', name: 'payment_id'},
			{data: 'user_id', name: 'user_id'},
			{data: 'content', name: 'content'},
			{data: 'address', name: 'address'},
			{data: 'amount', name: 'amount'},
			{data: 'status', name: 'status'},
			{data: 'action', name: 'action', orderable: false, searchable: false},
		]
	});

	$(document).on('click' , '.deleteOrder' ,function () {
		let orderID = this.id;
		let userFormUpdateUrl = `${BASE_URL}admin/order/delete-${orderID}`;
		Swal.fire({
			title: "Are you sure Yoy want to delete this Order?",
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
})
