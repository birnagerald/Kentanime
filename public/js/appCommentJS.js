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
        var $target = $($(this).data('target'));
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
        var $target = $($(this).data('target'));
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