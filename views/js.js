function loadFilm() {
    $.ajax({
        type: "GET",
        url: "/Film/All",
        success: function (msg) {
            $("div.films").html(msg);
        }
    });
}

function loadFilmSort(order,type) {
    $.ajax({
        type: "GET",
        url: "/Film/All/",
        data: "order="+order+'&type='+type,
        success: function (msg) {
            $("div.films").html(msg);
        }
    });
}

function loadActors() {
    $.ajax({
        type: "GET",
        url: "/Actor/All",
        success: function (msg) {
            $("div.actors").html(msg);
        }
    });
}

function deleteFilm(film_id) {
    $.ajax({
        type: "GET",
        url: "/Film/Delete/",
        data: 'film_id=' + film_id,
        success: function (msg) {
            $("div.films").html(msg);
        }
    });
}

function getFilm(film_id) {

    $.ajax({
        type: "GET",
        url: "/Film/Get/",
        data: 'film_id=' + film_id,
        success: function (msg) {
            $('.modal-body').append(msg);
        }
    });
}

function deleteActor(film_id, actor_id) {
    $.ajax({
        type: "GET",
        url: "/Film/DeleteActor/",
        data: 'film_id=' + film_id + '&actor_id=' + actor_id,
        success: location.reload()
    });
}

function addActor() {
    $( ".actors" ).first().clone().find("input:text,button:button").val("").end().appendTo(".form-inline");
}