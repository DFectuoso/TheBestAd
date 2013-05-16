jQuery(document).ready(function ($) {


});

// UPLOAD

// Custom example logic
$(function () {

    var uploader = new plupload.Uploader({

        runtimes: 'html5,browserplus',
        browse_button: 'pickfiles',
        container: 'container',
        max_file_size: '20mb',
        filters: [
            {title: "Image Files", extensions: "jpg,png"}
        ],
        url: ppi.baseUrl + 'files/upload/'
    });

    uploader.bind('Init', function (up, params) {
        //$('#filelist').html();
    });

    $('#pickfiles').click(function (e) {
        uploader.start();
        e.preventDefault();
    });

    uploader.init();
    uploader.bind('FilesAdded', function (up, files) {
        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('UploadProgress', function (up, file) {
        $('#' + file.id + " b").html(file.percent + "%");
    });

    uploader.bind('Error', function (up, err) {

        if (err.message == 'File extension error.') {
            $('#filelist').append("<div>ERROR/div>");
        } else {
            $('#filelist').append("<div>Error: " + err.code +
                ", Mensaje: " + err.message +
                (err.file ? ", Archivo: " + err.file.name : "") +
                "</div>"
            );
        }

        up.refresh(); // Reposition Flash/Silverlight
    });

    uploader.bind('FileUploaded', function (up, file) {
        $('#' + file.id + " b").html("100%");

        // redirect to payment...
    });

});