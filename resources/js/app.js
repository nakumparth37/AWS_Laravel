
const Swal = require('sweetalert2');

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


export const BASE_URL = window.env?.APP_URL;
export const csrfToken = $('meta[name="csrf-token"]').attr('content');


export function showPreviewImg(input, tagToPutPreview, type) {
    $(`.${tagToPutPreview.split('.')[1]}`).empty();
    if (input.files) {
        var NumberOfFile = input.files.length;
        for (let index = 0; index < NumberOfFile; index++) {
            var showImg = new FileReader();
            showImg.onload = function (event) {
                let imageContainer = $('<div class="image-container"></div>');
                let removeBtn = $('<i>').addClass('fa-solid fa-circle-xmark close-btn');
                let image = type === 'userImage' ? $($.parseHTML('<img>')).attr({'class':'imagesPreview rounded-circle', 'src': event.target?.result, style: "width:150px;height:150;" }) : ((NumberOfFile === 1)
                    ? $($.parseHTML('<img>')).attr({ 'src': event.target?.result, style: "width:250px;height:auto;" })
                    : $($.parseHTML('<img>')).attr({ 'src': event.target?.result, style: "width:120px;height:auto;" }).addClass(' m-2'))

                imageContainer.append(image).append(removeBtn);

                removeBtn.on('click', function() {
                    imageContainer.remove();
                });
                imageContainer.addClass('m-2').appendTo(tagToPutPreview);
            }


            showImg.readAsDataURL(input.files[index]);
        }
    }
}


// module.exports = showPreviewImg;


