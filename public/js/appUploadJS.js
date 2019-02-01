// let uploadHtml = '<label class="custom-file" id="customFile"><input type = "file" class="custom-file-input" id = "exampleInputFile" aria - describedby="fileHelp"><span class="custom-file-control form-control-file"></span></label>'

// $('div.custom-file').html(uploadHtml);

// $('div.custom-file').attr('id', 'customFile');
// let uploadField = $('#customFile');
// let uploadInputSpan = '<input type="file" class="custom-file-input" id="anime_imageFile" name="anime[imageFile]" aria-describedby="fileHelp"><span class="custom-file-control form-control-file"></span>'
// uploadField.html(uploadInputSpan);
// let test = '<span class="custom-file-control form-control-file"></span>';

// $(test).appendTo("div.custom-file");
if (!$("#post_imageFile").length) {

    $('.custom-file-input').on('change', function () {
        var fileName = document.getElementById("anime_imageFile").files[0].name;
        $(this).next('.custom-file-label').html("<span>" + fileName + "</span>");
    })
} else {
    $('.custom-file-input').on('change', function () {
        var fileName = document.getElementById("post_imageFile").files[0].name;
        $(this).next('.custom-file-label').html("<span>" + fileName + "</span>");
    })
}