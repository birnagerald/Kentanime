if ($("#post_imageFile").length) {
    $('.custom-file-input').on('change', function () {
        var fileName = document.getElementById("post_imageFile").files[0].name;
        $(this).next('.custom-file-label').html("<span>" + fileName + "</span>");
    })

} else if ($("#anime_imageFile").length) {
    $('.custom-file-input').on('change', function () {
        var fileName = document.getElementById("anime_imageFile").files[0].name;
        $(this).next('.custom-file-label').html("<span>" + fileName + "</span>");
    })


} else {
    $('.custom-file-input').on('change', function () {
        var fileName = document.getElementById("user_imageFile").files[0].name;
        $(this).next('.custom-file-label').html("<span>" + fileName + "</span>");
    })
}