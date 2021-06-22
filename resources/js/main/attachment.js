$(function () {
    $('#fileupload').fileupload({
        url: '/api/v1/recruiter/attachments/upload',
        disableImageResize: true,
        maxFileSize: 5000,
        acceptFileTypes: /(\.|\/)(gif|jpe?g|png|pdf)$/i,
    });
    $('#fileupload').addClass('fileupload-processing');
});
