$('#add-image').click(function () {

    // Je recupere numero des futurs champs
    const index = +$('#widgets-counter').val();

    // je recupere le prototype des entrees
    const tmpl = $('#activity_images').data('prototype').replace(/__name__/g, index);

    // j'injecte le code dans la div
    $('#activity_images').append(tmpl);

    $('#widgets-counter').val(index + 1);

    // je gere le button suppr
    handleDeleteButtons();

});

function handleDeleteButtons() {
    $('button[data-action="delete"]').click(function () {
        const target = this.dataset.target;
        $(target).remove();
    });
}

function updateCounter() {
    const count = +$('#activity_images div.form-group').length;

    $('#widgets-counter').val(count);
}

updateCounter();
handleDeleteButtons();