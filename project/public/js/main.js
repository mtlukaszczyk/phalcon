function logIn() {

    let user = $('#login').val();
    let password = $('#pass').val();

    $.ajax({
        url: baseUrl + '/user/login/',
        method: "POST",
        dataType: 'json',
        data: {
            login: user,
            password: password
        }
    }).done(function (result) {
        window.location.reload();

    }).fail(function () {

    });
}

function logOut() {

    $.ajax({
        url: baseUrl + '/user/logout/',
        method: "POST",
        dataType: 'json',
    }).done(function (result) {
        window.location.reload();

    }).fail(function () {

    });
}