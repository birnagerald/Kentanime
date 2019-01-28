function onClickCommentReport(e) {
    e.preventDefault();

    const url = this.href;

    axios.get(url).then(function (response) {

        alert(response.data.message);

    }).catch(function (error) {
        if (error.response.status === 403 || error.response.status === 401) {
            alert(error.response.data.message);
        } else {
            alert("Une erreur s'est produite, action impossible");
        }


    });
}

document.querySelectorAll('a.js-report').forEach(function (comment) {
    comment.addEventListener('click', onClickCommentReport);
})