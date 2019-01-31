// --------------------Report---------------------- //

function onClickCommentReport(e) {
    e.preventDefault();

    const url = this.href;

    axios.get(url).then(function (response) {
        $('.modal-title').html("Succès");
        $('.modal-body').html(response.data.message);


    }).catch(function (error) {
        if (error.response.status === 403 || error.response.status === 401) {
            $('.modal-title').html("Erreur");
            $('.modal-body').html(error.response.data.message);
        } else {
            $('.modal-title').html("Erreur");
            $('.modal-body').html("Une erreur s'est produite, action impossible");
        }


    });
}
jQuery(document).ready(function () {

    $('[data-toggle=modal]').on('click', function (e) {
        let $target = $($(this).data('target'));
        $target.data('triggered', true);
        setTimeout(function () {
            if ($target.data('triggered')) {
                $target.modal('show').data('triggered', false);
            };
        }, 1000); // milliseconds
        return false;
    });
    document.querySelectorAll('a.js-report').forEach(function (comment) {
        comment.addEventListener('click', onClickCommentReport);
    })

})

// --------------------Delete---------------------- //

function onClickCommentDelete(e) {
    e.preventDefault();

    const url = this.href;

    axios.get(url).then(function (response) {
        $('.modal-title').html("Succès");
        $('.modal-body').html(response.data.message);
        $('.comment-content-' + response.data.commentId).html("Commentaire supprimé");


    }).catch(function (error) {
        if (error.response.status === 401) {
            $('.modal-title').html("Erreur");
            $('.modal-body').html(error.response.data.message);
        } else if (error.response.status === 404) {
            $('.modal-title').html("Erreur");
            $('.modal-body').html("Commentaire introuvable");

        } else {
            $('.modal-title').html("Erreur");
            $('.modal-body').html("Une erreur s'est produite, action impossible");
        }


    });
}
jQuery(document).ready(function () {

    $('[data-toggle=modal]').on('click', function (e) {
        let $target = $($(this).data('target'));
        $target.data('triggered', true);
        setTimeout(function () {
            if ($target.data('triggered')) {
                $target.modal('show').data('triggered', false);
            };
        }, 1000); // milliseconds
        return false;
    });
    document.querySelectorAll('a.js-delete').forEach(function (comment) {
        comment.addEventListener('click', onClickCommentDelete);
    })

})

// --------------------New---------------------- //

function onClickCommentNew(e) {
    e.preventDefault();

    const url = this.dataset.url;
    const form = $('form').serialize();

    axios({
        method: 'post',
        url: url,
        data: form
    }).then(function (response) {
        $('.modal-title').html("Succès");
        $('.modal-body').html(response.data.message);
        CommentResponse = JSON.parse(response.data.comment);
        CommentVarNew = "<div class='comment-" + CommentResponse.id + "'><div class='row'><div class='col-12'><p class='post-metadata ml-auto '><span class='metadata-author '>" + CommentResponse.user + "</span></p></div><div class='div col-12 mb-5 comment-content-" + CommentResponse.id + "'>" + CommentResponse.content + "</div></div></div><hr>"
        $('.commentaire').prepend(CommentVarNew);


    }).catch(function (error) {
        if (error.response.status === 409) {
            $('.modal-title').html("Erreur");
            $('.modal-body').html(error.response.data.message);
        } else if (error.response.status === 401) {
            $('.modal-title').html("Erreur");
            $('.modal-body').html("error.response.data.message");

        } else {
            $('.modal-title').html("Erreur");
            $('.modal-body').html("Une erreur s'est produite, action impossible");
        }


    });

    // Same Ajax call using Jquery API
    // $.ajax({
    //     type: 'POST',
    //     url: url,
    //     data: form.serialize(),
    //     dataType: "json",
    //     success: function (response) {
    //         $('.modal-title').html("Succès");
    //         $('.modal-body').html(response.message);
    //     }
    // });


}

jQuery(document).ready(function () {

    $('[data-toggle=modal]').on('click', function (e) {
        let $target = $($(this).data('target'));
        $target.data('triggered', true);
        setTimeout(function () {
            if ($target.data('triggered')) {
                $target.modal('show').data('triggered', false);
            };
        }, 1000); // milliseconds
        return false;
    });

    button = document.querySelector('button.js-new');
    button.addEventListener('click', onClickCommentNew);


})